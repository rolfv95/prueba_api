
<div class="row">
    <div class="col-10">
        <h3><i class="bx bx-user"></i> Usuarios</h3>
    </div>
    <div class="col-2 text-right">
        <button id="new_user" class="btn btn-sm btn-outline-success absolute float-right"><i class="bx bx-plus"></i> Nuevo usuario</button>
    </div>
</div>

<br>

<div>
    <table id="users_table" class="table table-sm table-striped table-bordered table-hover">
        <thead class="thead-dark rounded">
            <tr>
                <th class="text-center">ID</th>
                <th>Alias</th>
                <th>Email</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($usuarios as $key => $usuario): ?>
            <tr>
                <td class="text-center"><?php echo $usuario->id; ?></td>
                <td><?php echo $usuario->alias; ?></td>
                <td><?php echo $usuario->email; ?></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-primary py-0 update" data-id="<?php echo $usuario->id; ?>">
                        <i class="bx bx-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger py-0 delete" data-id="<?php echo $usuario->id; ?>">
                        <i class="bx bx-trash"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- Form -->
<div id="user_modal" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark py-2">
        <h5 class="modal-title text-white"><i class="bx bx-user-plus"></i> <span id="title">Nuevo</span> Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="user_form">
        <div class="modal-body">
            <div class="row">
                <input type="hidden" id="id_user">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="small text-muted mb-0">Tipo de Usuario:</label>
                        <select id="user_type_id" class="form-control form-control-sm" required>
                            <option value="" disabled selected>-- Selecciona un tipo de usuario --</option>
                            <?php foreach ($tipos as $key => $tipo): ?>
                                <option value="<?php echo $tipo->id; ?>"> <?php echo $tipo->name; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="small text-muted mb-0">Alias:</label>
                        <input type="text" id="alias" class="form-control form-control-sm" required maxlenth="50" placeholder="Alias del usuario">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="small text-muted mb-0">Email:</label>
                        <input type="email" id="email" class="form-control form-control-sm" required maxlenth="100" placeholder="Email del usuario">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="small text-muted mb-0">Contraseña:</label>
                        <input type="password" id="password" class="form-control form-control-sm" required maxlenth="50" placeholder="Contraseña del usuario">
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