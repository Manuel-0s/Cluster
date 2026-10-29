<?php $permisos = $permisos ?? []; ?>
<?php $datos = $datos ?? []; ?>

<main class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h1 class="h3 mb-1">
                        <?php echo ($accion ?? 'create') === 'update' ? 'Editar rol' : 'Agregar rol'; ?>
                    </h1>
                    <p class="text-body-secondary mb-0">Completa la información del rol y sus permisos.</p>
                </div>

                <div class="card-body p-4">
                    <form enctype="multipart/form-data" action="rol.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="rol" class="form-label">Rol</label>
                                <input type="text" name="data[rol]" value="<?php echo $datos['rol'] ?? ''; ?>" class="form-control" id="rol">
                            </div>

                            <?php if (($accion ?? '') === 'update'): ?>
                                <div class="col-12">
                                    <label class="form-label d-block">Selecciona uno o más permisos para este rol.</label>
                                    <div class="d-grid gap-2 d-md-block" aria-label="Permisos del rol">
                                        <?php foreach ($permisos as $permiso): ?>
                                            <?php $permisoId = (int) $permiso['id_permiso']; ?>
                                            <input type="checkbox" class="btn-check" name="data[id_permiso][]" value="<?php echo $permisoId; ?>" id="permiso-<?php echo $permisoId; ?>" autocomplete="off" <?php echo in_array($permisoId, $datos['permisoes'] ?? [], true) ? 'checked' : ''; ?>>
                                            <label class="btn btn-outline-primary" for="permiso-<?php echo $permisoId; ?>"><?php echo $permiso['permiso']; ?></label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="rol.php" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" name="enviar" class="btn btn-success px-4">Guardar rol</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>