<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h2>Usuarios</h2>
        </div>
        <div class="row searchRow">
            <div class="col-md-12 col-sm-12 search-form">
                <form class="pull-right form-inline" method="post">
                    <fieldset>
                        <?= $this->Form->control('Search', ['type' => 'text', 'class' => 'form-control', 'label' => false]); ?>
                        <?= $this->Form->button('Buscar', ['type' => 'submit', 'class' => 'btn btn-info']) ?>
                    </fieldset>
                    <div id="showSearchOptBtn">
                        <i class="fa-solid fa-filter" style="color:#31B0D5;" title="opciones de búsqueda"></i><span class="showSearchOptBtnTitle">Más opciones</span>
                    </div>
                    <script>
                        $("#showSearchOptBtn").on("click", function() {
                            $('.searchOptDiv').toggle();
                        });
                    </script>
                    <div class="panel panel-default form-inline searchOptDiv">
                        <div class="panel-body">
                            <div class="panel panel-info roleOpts">
                                <div class="btn-group" role="group">

                                    <?= $this->Form->input('perfil', array(
                                        'type' => 'radio',
                                        'label' => false,
                                        'options' => array('admin' => ' Admin', 'usuario' => ' Usuario', '&' => ' Todos'),
                                    )); ?>
                                </div>
                            </div>
                            <div class="panel panel-info">
                                <div class="btn-group" role="group">
                                    <?= $this->Form->input('estado', array(
                                        'type' => 'radio',
                                        'label' => false,
                                        'options' => array(1 => ' Activo', 0 => ' Inactivo', '$' => ' Todos'),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('name', ['Nombre']) ?></th>
                        <th><?= $this->Paginator->sort('username', ['Usuario']) ?></th>
                        <th><?= $this->Paginator->sort('email', ['Correo electrónico']) ?></th>
                        <th><?= $this->Paginator->sort('role', ['Perfil']) ?></th>
                        <th style="text-align: center;"><?= $this->Paginator->sort('status', ['Activo']) ?></th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $this->Number->format($user->id) ?></td>
                            <td><?= h($user->name) ?></td>
                            <td><?= h($user->username) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td><?= h($user->role) ?></td>
                            <td style="text-align: center;"><?= $user->status ? '<i class="fa-solid fa-circle-check icon-green"></li>' : '<i class="fa-solid fa-circle-xmark icon-red"></i>' ?></td>
                            <td style="text-align: center;">
                                <?= $this->Html->link('Ver', ['action' => 'view', $user->id], ['class' => 'btn btn-sm btn-info']) ?>
                                <?= $this->Html->link('Editar', ['action' => 'edit', $user->id], ['class' => 'btn btn-sm btn-primary']) ?>
                                <?= $this->Form->postLink('Eliminar', ['action' => 'delete', $user->id], ['confirm' => 'Eliminar usuario ?', 'class' => 'btn btn-sm btn-danger']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< Anterior') ?>
                <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
                <?= $this->Paginator->next('Siguiente >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    </div>
</div>
