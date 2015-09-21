<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-home"></i></a></li>
                <li><a href="/admin">Admin</a></li>
                <li><a href="/admin/notifications">Notifications</a></li>
                <li class="active">Edit</li>
            </ol>
        </div>
    </div>

    <?php if ($success) : ?> 
    <div class="alert alert-info fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php foreach ($messages as $message) : ?> 
            <?= $message ?> 
        <?php endforeach ?>
    </div>
    <?php endif ?> 

    <?php if ($form->hasErrors()) : ?> 
    <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php foreach ($messages as $message) : ?> 
            <?= $message ?> 
        <?php endforeach ?>
    </div>
    <?php endif ?> 

    <div class="row">
        <div class="col-xs-12">
            <h1>Edit Notification</h1>
        </div>
    </div>

    <div class="clearfix">&nbsp;</div>

    <form role="form" action="/admin/notifications/edit/<?= $notification_id ?>" method="post">
    <div class="row">
        <div class="col-sm-6">
            <fieldset>
                <legend>Content</legend>
                <?php $form->showHidden() ?>
                <div class="form-group<?php echo $form->hasError('code') ? ' has-error' : '' ?>">
                    <label>Code: *</label>
                    <?php echo $form['code']->show(array('class' => 'form-control')) ?> 
                    <?php if ($form->hasError('code')) : ?><span class="help-block"><?php echo $form->getError('code') ?></span><?php endif ?>
                </div>
                <div class="form-group<?php echo $form->hasError('title') ? ' has-error' : '' ?>">
                    <label>Title: *</label>
                    <?php echo $form['title']->show(array('type' => 'title', 'class' => 'form-control')) ?> 
                    <?php if ($form->hasError('title')) : ?><span class="help-block"><?php echo $form->getError('title') ?></span><?php endif ?>
                </div>
                <div class="form-group<?php echo $form->hasError('body') ? ' has-error' : '' ?>">
                    <label>Body: *</label>
                    <?php echo $form['body']->show(array('class' => 'form-control', 'rows' => '10')) ?> 
                    <?php if ($form->hasError('body')) : ?><span class="help-block"><?php echo $form->getError('body') ?></span><?php endif ?>
                </div>
            </fieldset>
        </div>
        <div class="col-sm-6">
            <fieldset>
                <legend>Relations</legend>
                <div class="form-group<?php echo $form->hasError('entity_data_id') ? ' has-error' : '' ?>">
                    <label>Entity: *</label>
                    <?php echo $form['entity_data_id']->show(array('class' => 'form-control')) ?> 
                    <?php if ($form->hasError('entity_data_id')) : ?><span class="help-block"><?php echo $form->getError('entity_data_id') ?></span><?php endif ?>
                </div>
                <div class="form-group<?php echo $form->hasError('entity_service_id') ? ' has-error' : '' ?>">
                    <label>Services: *</label>
                    <?php echo $form['entity_service_id']->show(array('class' => 'form-control', 'multiple' => 'multiple')) ?> 
                    <?php if ($form->hasError('entity_service_id')) : ?><span class="help-block"><?php echo $form->getError('entity_service_id') ?></span><?php endif ?>
                </div>
                <div class="form-group<?php echo $form->hasError('user_type_id') ? ' has-error' : '' ?>">
                    <label>User Types: *</label>
                    <?php echo $form['user_type_id']->show(array('class' => 'form-control', 'multiple' => 'multiple')) ?> 
                    <?php if ($form->hasError('user_type_id')) : ?><span class="help-block"><?php echo $form->getError('user_type_id') ?></span><?php endif ?>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-default" href="/admin/notifications">Back</a>
        </div>
    </div>
    </form>
</div>
