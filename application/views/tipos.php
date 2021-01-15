
<div class="row">
    <div class="col-10">
        <h3><i class="bx bx-category"></i> Tipos de Usuario</h3>
    </div>
    <div class="col-2 text-right">
        <button id="new_type" class="btn btn-sm btn-outline-success absolute float-right"><i class="bx bx-plus"></i> Nuevo tipo</button>
    </div>
</div>

<br>

<div>
    <table id="types_table" class="table table-sm table-striped table-bordered table-hover">
        <thead class="thead-dark rounded">
            <tr>
                <th class="text-center">ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th class="text-center">Admin</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tipos as $key => $tipo): ?>
            <tr>
                <td class="text-center"><?php echo $tipo->id; ?></td>
                <td><?php echo $tipo->name; ?></td>
                <td><?php echo $tipo->description; ?></td>
                <td class="text-center">
                    <?php if( $tipo->is_admin == 1 ): ?>
                        <span class="badge badge-success">admin</span>
                    <?php else: ?>
                        <span class="badge badge-secondary">no</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-primary py-0 update" data-id="<?php echo $tipo->id; ?>">
                        <i class="bx bx-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger py-0 delete" data-id="<?php echo $tipo->id; ?>">
                        <i class="bx bx-trash"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- Form -->
<div id="type_modal" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark py-2">
        <h5 class="modal-title text-white"><i class="bx bx-user-plus"></i> <span id="title">Nuevo</span> Tipo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="type_form">
        <div class="modal-body">
            <div class="row">
                <input type="hidden" id="id">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="small text-muted mb-0">Nombre:</label>
                        <input type="text" id="name" class="form-control form-control-sm" required maxlenth="50" placeholder="Nombre de tipo de usuario">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="small text-muted mb-0">Descripción:</label>
                        <textarea id="description" class="form-control form-control-sm" required rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_admin">
                        <label class="custom-control-label small text-muted" for="is_admin">Admin</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal"><i class="bx bx-x"></i> Cancelar</button>
            <button type="submit" class="btn btn-sm btn-primary"><i class="bx bx-save"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>