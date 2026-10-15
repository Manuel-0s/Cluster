<form action="proveedor.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

    <div class="mb-3">
        <label class="form-label">Razón Social</label>
        <input type="text" name="data[razon_social]" value="<?php echo $datos['razon_social'] ?? ''; ?>" class="form-control" id="razon_social" required
        pattern = "[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\s]{1,100}">
    </div>

    <div class="mb-3">
        <label class="form-label">RFC</label>
        <input type="text" name="data[rfc]" value="<?php echo $datos['rfc'] ?? ''; ?>" class="form-control" id="rfc" required
        pattern = "[A-Z]{4}[0-9]{6}[A-Z0-9]{3}">
    </div>

    <input type="submit" name="enviar" class="btn btn-success" value="Guardar">
</form>