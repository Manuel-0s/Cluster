<main class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h1 class="h3 mb-1">
                        <?php echo ($accion ?? 'create') === 'update' ? 'Editar empleado' : 'Agregar empleado'; ?>
                    </h1>
                    <p class="text-body-secondary mb-0">Completa la información del empleado y su cuenta de acceso.</p>
                </div>

                <div class="card-body p-4">
                    <form enctype="multipart/form-data" action="empleado.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

                        <h2 class="h6 text-uppercase text-body-secondary border-bottom pb-2 mb-3">Datos personales</h2>
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="data[nombre]" value="<?php echo $datos['nombre'] ?? ''; ?>" class="form-control" id="nombre" required
                                    pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\s]{1,100}">
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="primer_apellido" class="form-label">Primer apellido</label>
                                <input type="text" name="data[primer_apellido]" value="<?php echo $datos['primer_apellido'] ?? ''; ?>" class="form-control" id="primer_apellido" required
                                    pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\s]{1,100}">
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="segundo_apellido" class="form-label">Segundo apellido</label>
                                <input type="text" name="data[segundo_apellido]" value="<?php echo $datos['segundo_apellido'] ?? ''; ?>" class="form-control" id="segundo_apellido"
                                    pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\s]{1,100}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="rfc" class="form-label">RFC</label>
                                <input type="text" name="data[rfc]" value="<?php echo $datos['rfc'] ?? ''; ?>" class="form-control text-uppercase" id="rfc" required
                                    pattern="[A-Z]{4}[0-9]{6}[A-Z0-9]{3}" maxlength="13">
                                <div class="form-text">Formato: 4 letras, fecha de nacimiento y homoclave.</div>
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-body-secondary border-bottom pb-2 mb-3 mt-4">Fotografía</h2>
                        <div class="row g-3">
                            <div class="col-12 col-md-8">
                                <div class="ratio ratio-4x3 bg-body-secondary rounded overflow-hidden">
                                    <video id="camara-empleado" class="w-100 h-100 object-fit-cover" autoplay playsinline
                                        aria-label="Vista previa de la cámara"></video>
                                    <img id="foto-empleado" class="w-100 h-100 object-fit-cover <?php echo empty($datos['foto']) ? 'd-none' : ''; ?>"
                                        src="<?php echo empty($datos['foto']) ? '' : '../images/uploads/' . $datos['foto']; ?>"
                                        alt="Vista previa de la fotografía">
                                    <div id="camara-mensaje" class="d-flex align-items-center justify-content-center text-body-secondary p-3 text-center">
                                        <?php echo empty($datos['foto']) ? 'Activa la cámara para tomar la fotografía.' : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 d-flex flex-column justify-content-center gap-2">
                                <button type="button" id="iniciar-camara" class="btn btn-outline-primary">Activar cámara</button>
                                <button type="button" id="tomar-foto" class="btn btn-primary" disabled>Tomar foto</button>
                                <button type="button" id="repetir-foto" class="btn btn-outline-secondary d-none">Tomar otra</button>
                                <label for="archivo-foto" class="form-label mb-0 mt-2">O selecciona una imagen</label>
                                <input type="file" name="data[foto]" id="archivo-foto" class="form-control" accept="image/*" capture="user">
                                <div id="camara-error" class="form-text text-danger" role="alert"></div>
                            </div>
                        </div>

                        <h2 class="h6 text-uppercase text-body-secondary border-bottom pb-2 mb-3 mt-4">Cuenta de acceso</h2>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" name="data[correo]" value="<?php echo $datos['correo'] ?? ''; ?>" class="form-control" id="correo" required
                                    pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
                            </div>

                            <div class="col-12">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" name="data[contrasena]" value="<?php echo $datos['contrasena'] ?? ''; ?>" class="form-control" id="contrasena" required>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="empleado.php" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" name="enviar" class="btn btn-success px-4">Guardar empleado</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    (() => {
        const video = document.getElementById('camara-empleado');
        const preview = document.getElementById('foto-empleado');
        const message = document.getElementById('camara-mensaje');
        const startButton = document.getElementById('iniciar-camara');
        const captureButton = document.getElementById('tomar-foto');
        const retakeButton = document.getElementById('repetir-foto');
        const fileInput = document.getElementById('archivo-foto');
        const errorMessage = document.getElementById('camara-error');
        const canvas = document.createElement('canvas');
        let stream;

        const stopCamera = () => {
            if (stream) {
                stream.getTracks().forEach((track) => track.stop());
                stream = undefined;
            }
        };

        const showError = (messageText) => {
            errorMessage.textContent = messageText;
            captureButton.disabled = true;
        };

        const startCamera = async () => {
            errorMessage.textContent = '';
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                showError('Tu navegador no permite usar la cámara. Selecciona una imagen.');
                return;
            }

            stopCamera();
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                video.srcObject = stream;
                video.classList.remove('d-none');
                preview.classList.add('d-none');
                message.classList.add('d-none');
                captureButton.disabled = false;
                startButton.textContent = 'Reactivar cámara';
            } catch (error) {
                showError('No fue posible acceder a la cámara. Revisa los permisos o selecciona una imagen.');
            }
        };

        startButton.addEventListener('click', startCamera);

        captureButton.addEventListener('click', () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            canvas.toBlob((blob) => {
                if (!blob) {
                    showError('No fue posible preparar la fotografía.');
                    return;
                }

                const file = new File([blob], 'empleado.jpg', { type: 'image/jpeg' });
                const transfer = new DataTransfer();
                transfer.items.add(file);
                fileInput.files = transfer.files;
                preview.src = URL.createObjectURL(blob);
                preview.classList.remove('d-none');
                video.classList.add('d-none');
                message.classList.add('d-none');
                captureButton.disabled = true;
                retakeButton.classList.remove('d-none');
                stopCamera();
            }, 'image/jpeg', 0.8);
        });

        retakeButton.addEventListener('click', () => {
            fileInput.value = '';
            retakeButton.classList.add('d-none');
            startCamera();
        });

        fileInput.addEventListener('change', () => {
            const [file] = fileInput.files;
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.addEventListener('load', () => {
                preview.src = reader.result;
                preview.classList.remove('d-none');
                video.classList.add('d-none');
                message.classList.add('d-none');
                retakeButton.classList.remove('d-none');
                stopCamera();
                captureButton.disabled = true;
            });
            reader.readAsDataURL(file);
        });

        window.addEventListener('beforeunload', stopCamera);
    })();
</script>
