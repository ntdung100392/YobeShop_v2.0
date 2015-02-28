<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">          
        <a data-toggle="tooltip" class="btn btn-primary" onclick="$('#form').submit();"><?php echo $button_save; ?></a>
        <a data-toggle="tooltip" class="btn btn-primary" onclick="" href="#"><?php echo $button_cancel ?></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i>Wholesale List</h3>
      </div>
      <div class="content">
        <form action="<?php echo $update_action; ?>" method="post" enctype="multipart/form-data" id="form">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left"><?php echo $column_name; ?></td>
                            <td class="text-left"><?php echo $column_percent; ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($customer_groups) { ?>
                        <?php foreach ($customer_groups as $customer_group) { ?>
                        <tr>
                            <td class="text-left"><?php echo $customer_group['name']; ?></td>
                            <td class="text-left"><input name="customer_groups[<?php echo $customer_group['customer_group_id']; ?>]" type="number" max=100 min=1 value="<?php echo $customer_group['sale_off_percent']; ?>" /></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>