<?php $marcas = $marcas ?? []; ?>
<?php $datos = $datos ?? []; ?>

<form enctype="multipart/form-data" action="rol.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

    <div class="mb-3">
        <label class="form-label">Rol</label>
        <input type="text" name="data[rol]" value="<?php echo $datos['rol'] ?? ''; ?>" class="form-control" id="rol">
    </div>

    <input type="submit" name="enviar" class="btn btn-success" value="Guardar">
</form>