<?php
$modelPath = 'models/tshirt.glb'; // Path to your GLTF model
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T-Shirt Customization</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }
        #3d-container {
            width: 100vw;
            height: 80vh;
            border: 2px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            background-color: #f9f9f9;
            margin: 20px auto;
        }
        h1 {
            text-align: center;
            position: absolute;
            top: 20px;
            width: 100%;
            color: #333;
            z-index: 10;
        }
        #controls {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
            background: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 5px;
        }
        .text-icon {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/FontLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/fonts/helvetiker_regular.typeface.json"></script>
</head>
<body>
    <h1>Customize This Hard Shirt</h1>
    <div id="controls">
        <label for="colorPicker">Choose T-Shirt Color:</label>
        <input type="color" id="colorPicker" value="#ff0000" />
        <br />
        <span class="text-icon" id="addTextButton">Add Text</span>
    </div>
    <div id="3d-container"></div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const scene = new THREE.Scene();
            scene.background = new THREE.Color(0xffffff);

            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            document.getElementById('3d-container').appendChild(renderer.domElement);

            const ambientLight = new THREE.AmbientLight(0x404040);
            scene.add(ambientLight);
            
            const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
            directionalLight.position.set(5, 10, 7.5);
            scene.add(directionalLight);

            const controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enablePan = false;

            const loader = new THREE.GLTFLoader();
            let model;

            loader.load('<?php echo $modelPath; ?>', (gltf) => {
                model = gltf.scene;
                scene.add(model);

                const box = new THREE.Box3().setFromObject(model);
                const center = box.getCenter(new THREE.Vector3());
                const size = box.getSize(new THREE.Vector3());

                camera.position.set(center.x, center.y + size.y / 1.1, size.z * 3);
                camera.lookAt(center);

                controls.target.copy(center);
                controls.update();

                const colorPicker = document.getElementById('colorPicker');
                colorPicker.addEventListener('input', (event) => {
                    const color = event.target.value;
                    model.traverse((child) => {
                        if (child.isMesh) {
                            child.material.color.set(color);
                        }
                    });
                });

                // Click event for adding text
                document.getElementById('addTextButton').addEventListener('click', () => {
                    const input = prompt("Enter text to add:");
                    if (input) {
                        addText(input, center);
                    }
                });
            }, undefined, (error) => {
                console.error(error);
            });

            function addText(text, position) {
                const fontLoader = new THREE.FontLoader();
                fontLoader.load('https://cdn.jsdelivr.net/npm/three@0.128.0/examples/fonts/helvetiker_regular.typeface.json', (font) => {
                    const textGeometry = new THREE.TextGeometry(text, {
                        font: font,
                        size: 0.5,
                        height: 0.1,
                        curveSegments: 12,
                        bevelEnabled: false
                    });
                    const textMaterial = new THREE.MeshBasicMaterial({ color: 0x000000 });
                    const textMesh = new THREE.Mesh(textGeometry, textMaterial);
                    
                    // Position text on the model
                    const box = new THREE.Box3().setFromObject(model);
                    const center = box.getCenter(new THREE.Vector3());
                    textMesh.position.set(center.x, center.y + 1, center.z); // Adjust Y position as needed
                    scene.add(textMesh);

                    // Add edit and delete options
                    addEditDeleteOptions(textMesh);
                });
            }

            function addEditDeleteOptions(textMesh) {
                const editButton = document.createElement('button');
                editButton.innerText = "Edit";
                editButton.onclick = () => {
                    const newText = prompt("Edit text:", textMesh.geometry.parameters.text);
                    if (newText) {
                        updateText(textMesh, newText);
                    }
                };

                const deleteButton = document.createElement('button');
                deleteButton.innerText = "Delete";
                deleteButton.onclick = () => {
                    scene.remove(textMesh);
                    document.body.removeChild(editButton);
                    document.body.removeChild(deleteButton);
                };

                document.body.appendChild(editButton);
                document.body.appendChild(deleteButton);
                editButton.style.position = 'absolute';
                editButton.style.top = '10px';
                editButton.style.right = '10px';
                deleteButton.style.position = 'absolute';
                deleteButton.style.top = '40px';
                deleteButton.style.right = '10px';
            }

            function updateText(textMesh, newText) {
                scene.remove(textMesh);
                addText(newText, textMesh.position); // Re-add text at the same position
            }

            function animate() {
                requestAnimationFrame(animate);
                controls.update();
                renderer.render(scene, camera);
            }
            animate();

            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
        });
    </script>
</body>
</html>
