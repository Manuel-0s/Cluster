<?php $proveedores = $proveedores ?? []; ?>
<?php $datos = $datos ?? []; ?>

<form enctype="multipart/form-data" action="marca.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

    <?php if (!empty($datos['logo'])): ?>
        <div class="mb-3"> 
            <img  src="../images/uploads/<?php echo $datos['logo'] ?? ''; ?>" width="150px">
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Marca</label>
        <input type="text" name="data[marca]" value="<?php echo $datos['marca'] ?? ''; ?>" class="form-control" id="marca" required>
    </div>

    <div class="mb-3">
        <label class="form-label">logo</label>
        <input type="file" name="data[logo]" class="form-control" id="logo" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Proveedor</label>
        <select name="data[id_proveedor]" class="form-select" id="id_proveedor" required>
            <?php
            foreach($proveedores as $proveedor): 
            $selected = "";
            if ($datos['id_proveedor'] == $proveedor['id']){
                $selected = 'selected';
            }
            ?>
                <option value="<?php echo $proveedor['id']; ?>" <?php 
                    echo $selected; 
                    ?>> 
                    <?php echo $proveedor['razon_social']; ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    <input type="submit" name="enviar" class="btn btn-success" value="Guardar">
</form>