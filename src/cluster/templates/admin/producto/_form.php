<?php $marcas = $marcas ?? []; ?>
<?php $datos = $datos ?? []; ?>

<form enctype="multipart/form-data" action="producto.php?accion=<?php echo $accion ?? 'create'; ?>&id=<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? $datos['id'] ?? ''; ?>">

    <?php if (!empty($datos['foto'])): ?>
        <div class="mb-3"> 
            <img  src="../images/uploads/<?php echo $datos['foto'] ?? ''; ?>" width="150px">
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">producto</label>
        <input type="text" name="data[producto]" value="<?php echo $datos['producto'] ?? ''; ?>" class="form-control" id="producto">
    </div>

    <div class="mb-3">
        <label class="form-label">foto</label>
        <input type="file" name="data[foto]" class="form-control" id="foto">
    </div>

    <div class="mb-3">
        <label class="form-label">Precio</label>
        <input type="text" name="data[precio]" value="<?php echo $datos['precio'] ?? ''; ?>" class="form-control" id="precio">
    </div>

    <div class="mb-3">
        <label class="form-label">Marca</label>
        <select name="data[id_marca]" class="form-select" id="id_marca">
            <?php
            foreach($marcas as $marca): 
            $selected = "";
            if ($datos['id_marca'] == $marca['id']){
                $selected = 'selected';
            }
            ?>
                <option value="<?php echo $marca['id']; ?>" <?php 
                    echo $selected; 
                    ?>> 
                    <?php echo $marca['marca']; ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    <input type="submit" name="enviar" class="btn btn-success" value="Guardar">
</form>