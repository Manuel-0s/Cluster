<?php $datos = $datos ?? []; ?>
<?php $roles = $roles ?? []; ?>

<main class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h1 class="h3 mb-1">
                        <?php echo ($accion ?? 'create') === 'update' ? 'Editar usuario' : 'Agregar usuario'; ?>
                    </h1>
                    <p class="text-body-secondary mb-0">Completa la información del usuario y sus roles.</p>
                </div>

                <div class="card-body p-4">
                    <form enctype="multipart/form-data" action="usuario.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" name="data[correo]" value="<?php echo $datos['correo'] ?? ''; ?>" class="form-control" id="correo">
                            </div>

                            <div class="col-12">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" name="data[contrasena]" class="form-control" id="contrasena">
                            </div>

                            <?php if (($accion ?? '') === 'update'): ?>
                                <div class="col-12">
                                    <label class="form-label d-block">Selecciona los roles</label>
                                    <div class="d-grid gap-2 d-md-block" aria-label="Roles del usuario">
                                        <?php foreach ($roles as $rol): ?>
                                            <?php $rolId = (int) $rol['id_rol']; ?>
                                            <input type="checkbox" class="btn-check" name="data[id_rol][]" value="<?php echo $rolId; ?>" id="rol-<?php echo $rolId; ?>" autocomplete="off" <?php echo in_array($rolId, $datos['roles'] ?? [], true) ? 'checked' : ''; ?>>
                                            <label class="btn btn-outline-primary" for="rol-<?php echo $rolId; ?>"><?php echo $rol['rol']; ?></label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="usuario.php" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" name="enviar" class="btn btn-success px-4">Guardar usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>