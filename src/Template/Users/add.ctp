<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>Crear usuario</h2>
        </div>
        <?= $this->Form->create($user) ?>
        <fieldset>
            <?php
            echo $this->Form->input('name', ['label' => 'Nombre']);
            echo $this->Form->input('username', ['label' => 'Usuario']);
            echo $this->Form->input('email', ['label' => 'Correo electrónico']);
            echo $this->Form->input('password', ['label' => 'Contraseña']);
            // #eggodev -> Agregué un campo para confirmar la contraseña
            echo $this->Form->input('confirm_password', ['type' => 'password', 'label' => 'Confirmar contraseña']);
            echo $this->Form->input('role', ['options' => ['admin' => 'Admin', 'usuario' => 'Usuario'], 'label' => 'Perfil']);
            echo $this->Form->input('status', ['label' => 'Activo', 'checked' => true]);
            ?>
        </fieldset>
        <div class="btn-field">
            <?= $this->Form->button('Crear', ['class' => 'btn btn-info']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
