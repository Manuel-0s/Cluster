<main class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h1 class="h3 mb-1">
                        <?php echo ($accion ?? 'create') === 'update' ? 'Editar proveedor' : 'Agregar proveedor'; ?>
                    </h1>
                    <p class="text-body-secondary mb-0">Completa la información del proveedor.</p>
                </div>

                <div class="card-body p-4">
                    <form action="proveedor.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="razon_social" class="form-label">Razón social</label>
                                <input type="text" name="data[razon_social]" value="<?php echo $datos['razon_social'] ?? ''; ?>" class="form-control" id="razon_social" required
                                    pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\s]{1,100}">
                            </div>

                            <div class="col-12">
                                <label for="rfc" class="form-label">RFC</label>
                                <input type="text" name="data[rfc]" value="<?php echo $datos['rfc'] ?? ''; ?>" class="form-control text-uppercase" id="rfc" required
                                    pattern="[A-Z]{4}[0-9]{6}[A-Z0-9]{3}" maxlength="13">
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="proveedor.php" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" name="enviar" class="btn btn-success px-4">Guardar proveedor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>