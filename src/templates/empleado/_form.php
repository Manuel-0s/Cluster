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
                    <form action="empleado.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
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
