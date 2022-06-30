<div class="view-card-container">
    <div class="view-card">
        <h2><?= h($user->name) ?></h2>
        <br>
        <dl>
            <dt>Nombre</dt>
            <dd>
                <?= h($user->name) ?>
                &nbsp;
            </dd>
            <br>

            <dt>Usuario</dt>
            <dd>
                <?= h($user->username) ?>
                &nbsp;
            </dd>
            <br>

            <dt>Correo electrónico</dt>
            <dd>
                <?= h($user->email) ?>
                &nbsp;
            </dd>
            <br>

            <dt>Contraseña</dt>
            <dd>
                <?= h($user->password) ?>
                &nbsp;
            </dd>
            <br>

            <dt>Perfil</dt>
            <dd>
                <?= h($user->role) ?>
                &nbsp;
            </dd>
            <br>

            <dt>Habilitado</dt>
            <dd>
                <?= $user->status ? 'Si' : 'No' ?>
                &nbsp;
            </dd>
        </dl>
    </div>
</div>
