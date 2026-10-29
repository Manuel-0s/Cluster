<?php $proveedores = $proveedores ?? []; ?>
<?php $datos = $datos ?? []; ?>

<main class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h1 class="h3 mb-1">
                        <?php echo ($accion ?? 'create') === 'update' ? 'Editar marca' : 'Agregar marca'; ?>
                    </h1>
                    <p class="text-body-secondary mb-0">Completa la información de la marca.</p>
                </div>

                <div class="card-body p-4">
                    <form enctype="multipart/form-data" action="marca.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

                        <?php if (!empty($datos['logo'])): ?>
                            <div class="mb-3">
                                <img src="../images/uploads/<?php echo $datos['logo'] ?? ''; ?>" width="150px">
                            </div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" name="data[marca]" value="<?php echo $datos['marca'] ?? ''; ?>" class="form-control" id="marca" required>
                            </div>

                            <div class="col-12">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" name="data[logo]" class="form-control" id="logo" required>
                            </div>

                            <div class="col-12">
                                <label for="id_proveedor" class="form-label">Proveedor</label>
                                <select name="data[id_proveedor]" class="form-select" id="id_proveedor" required>
                                    <?php foreach ($proveedores as $proveedor): ?>
                                        <option value="<?php echo $proveedor['id']; ?>" <?php echo ($datos['id_proveedor'] ?? '') == $proveedor['id'] ? 'selected' : ''; ?>>
                                            <?php echo $proveedor['razon_social']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="marca.php" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" name="enviar" class="btn btn-success px-4">Guardar marca</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>