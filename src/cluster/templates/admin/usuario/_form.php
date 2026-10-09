<?php $datos = $datos ?? []; ?>
<?php $roles = $roles ?? []; ?>

<form enctype="multipart/form-data" action="usuario.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

    <div class="mb-3">
        <label class="form-label">Correo</label>
        <input type="mail" name="data[correo]" value="<?php echo $datos['correo'] ?? ''; ?>" class="form-control" id="correo">
    </div>

    <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" name="data[contrasena]" value="<?php echo $datos['contrasena'] ?? ''; ?>" class="form-control" id="contrasena">
    </div>

    <?php if (($accion ?? '') === 'update'): ?>
        <div class="mb-3">
            <label class="form-label d-block">Selecciona los roles</label>

            <div class="btn-group" role="group" aria-label="Roles del usuario">
                <?php foreach ($roles as $rol): ?>
                    <?php $rolId = (int) $rol['id_rol']; ?>
                    <input
                        type="checkbox"
                        class="btn-check"
                        name="data[id_rol][]"
                        value="<?php echo $rolId; ?>"
                        id="rol-<?php echo $rolId; ?>"
                        autocomplete="off"
                        <?php echo in_array($rolId, $datos['roles'] ?? [], true) ? 'checked' : ''; ?>
                    >
                    <label class="btn btn-outline-primary" for="rol-<?php echo $rolId; ?>">
                        <?php echo $rol['rol']; ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <input type="submit" name="enviar" class="btn btn-success" value="Guardar">
</form>