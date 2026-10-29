<?php $permisos = $permisos ?? []; ?>
<?php $datos = $datos ?? []; ?>

<main class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h1 class="h3 mb-1">
                        <?php echo ($accion ?? 'create') === 'update' ? 'Editar permiso' : 'Agregar permiso'; ?>
                    </h1>
                    <p class="text-body-secondary mb-0">Completa la información del permiso.</p>
                </div>

                <div class="card-body p-4">
                    <form enctype="multipart/form-data" action="permiso.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="permiso" class="form-label">Permiso</label>
                                <input type="text" name="data[permiso]" value="<?php echo $datos['permiso'] ?? ''; ?>" class="form-control" id="permiso">
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="permiso.php" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" name="enviar" class="btn btn-success px-4">Guardar permiso</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>