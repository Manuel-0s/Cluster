<?php $permisos = $permisos ?? []; ?>
<?php $datos = $datos ?? []; ?>

<form enctype="multipart/form-data" action="rol.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

    <div class="mb-3">
        <label class="form-label">Rol</label>
        <input type="text" name="data[rol]" value="<?php echo $datos['rol'] ?? ''; ?>" class="form-control" id="rol">
    </div>

     <?php if (($accion ?? '') === 'update'): ?>
        <div class="mb-3">
            <label class="form-label d-block">Selecciona uno o más permisos para este rol.</label>
            <div class="d-grid gap-2 d-md-block" aria-label="permisoes del usuario">
                <?php foreach ($permisos as $permiso): ?>
                    <?php $permisoId = (int) $permiso['id_permiso']; ?>
                    <input
                        type="checkbox"
                        class="btn-check"
                        name="data[id_permiso][]"
                        value="<?php echo $permisoId; ?>"
                        id="permiso-<?php echo $permisoId; ?>"
                        autocomplete="off"
                        <?php echo in_array($permisoId, $datos['permisoes'] ?? [], true) ? 'checked' : ''; ?>
                    >
                    <label class="btn btn-outline-primary" for="permiso-<?php echo $permisoId; ?>">
                        <?php echo $permiso['permiso']; ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <input type="submit" name="enviar" class="btn btn-success" value="Guardar">
</form>