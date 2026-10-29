<?php $marcas = $marcas ?? []; ?>
<?php $datos = $datos ?? []; ?>

<main class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h1 class="h3 mb-1">
                        <?php echo ($accion ?? 'create') === 'update' ? 'Editar producto' : 'Agregar producto'; ?>
                    </h1>
                    <p class="text-body-secondary mb-0">Completa la información del producto.</p>
                </div>

                <div class="card-body p-4">
                    <form enctype="multipart/form-data" action="producto.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

                        <?php if (!empty($datos['foto'])): ?>
                            <div class="mb-3">
                                <img src="../images/uploads/<?php echo $datos['foto'] ?? ''; ?>" width="150px">
                            </div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="producto" class="form-label">Producto</label>
                                <input type="text" name="data[producto]" value="<?php echo $datos['producto'] ?? ''; ?>" class="form-control" id="producto">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="text" name="data[precio]" value="<?php echo $datos['precio'] ?? ''; ?>" class="form-control" id="precio">
                            </div>

                            <div class="col-12">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" name="data[foto]" class="form-control" id="foto">
                            </div>

                            <div class="col-12">
                                <label for="id_marca" class="form-label">Marca</label>
                                <select name="data[id_marca]" class="form-select" id="id_marca">
                                    <?php foreach ($marcas as $marca): ?>
                                        <option value="<?php echo $marca['id']; ?>" <?php echo ($datos['id_marca'] ?? '') == $marca['id'] ? 'selected' : ''; ?>>
                                            <?php echo $marca['marca']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="producto.php" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" name="enviar" class="btn btn-success px-4">Guardar producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>