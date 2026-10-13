<?php $permisos = $permisos ?? []; ?>
<?php $datos = $datos ?? []; ?>

<form enctype="multipart/form-data" action="permiso.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">


    <div class="mb-3">
        <label class="form-label">Permiso</label>
        <input type="text" name="data[permiso]" value="<?php echo $datos['permiso'] ?? ''; ?>" class="form-control" id="permiso" required>
    </div>
    
    <input type="submit" name="enviar" class="btn btn-success" value="Guardar">
</form>