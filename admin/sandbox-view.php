<?php 
global $content;
$sandboxes = $content['sandboxes'];
?>

<div class="row">       
  <div class="col-lg-12">
    <form method="post">        
          <div class="input-group input-group-lg">
            <input name="sandbox" placeholder="Sandbox name"  value="" required="required" type="text" class="form-control">
            <span class="input-group-btn">
              <button class="btn btn-info" name="action" value="create" type="submit">Create</button>
            </span>
          </div>
    </form>
  </div>
</div>

<div class="row">          
<div class="col-lg-12">

<div class="panel-group" id="accordion">

        <?php if(count($sandboxes) == 0): ?>
                no sandbox found.
        <?php endif; ?>
                    
        <?php  foreach($sandboxes as $sandbox){ ?>
                   <div class="panel panel-default">
                   <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $sandbox->getSluggedName();?>">
                            <?php echo $sandbox->name; ?>
                            </a>
			                      <a href="<?php echo $sandbox->getUrl(); ?>" target="_blank" class="visit"><span class="glyphicon glyphicon-send"></span></a>
                        </h4>
                   </div>
                   <div id="collapse-<?php echo $sandbox->getSluggedName(); ?>" class="panel-collapse collapse">
                   <div class="panel-body">                
        <table class="table">
        <thead>
            <tr>
                <th class="hidden-xs hidden-sm">DB Name</th>
                <th class="hidden-xs hidden-sm">DB Pwd</th>
                <th class="hidden-xs hidden-sm">Directory</th>                   
                <th class="hidden-xs hidden-sm">Installation Package</th>
                <th class="hidden-xs hidden-sm">Actions</th>
            </tr>
        </thead>        
         <tbody>       
            <tr>			
            <td class="col-md-1">
              <div class="input-group">
                <div class="input-group-addon">DB Name</div>
                <input type="text" readonly class="form-control copyable" value="<?php echo $sandbox->dbname; ?>" onclick="this.select();">
              </div>            
            </td>
            <td class="col-md-2">
              <div class="input-group">
                <div class="input-group-addon">DB Pwd</div>
                <input type="text" readonly class="form-control copyable" value="<?php echo $sandbox->dbpassword; ?>" onclick="this.select();">
              </div>
            </td>                       
            <td class="col-md-4">
              <div class="input-group">
                <div class="input-group-addon">Path</div>
                <input type="text" readonly class="form-control copyable" value="<?php echo $sandbox->getPath(); ?>" onclick="this.select();">
              </div>
            </td>
            <form method="post">
            <input type="hidden" name="sandbox" value="<?php echo $sandbox->name; ?>">
            <td class="col-md-2"><?php echo InstallBundle::getHtmlSelectInstall($sandbox->installedVersion); ?> </td>
            <td class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <div class="btn-group btn-group-justified">
            <div class="btn-group">
            <button type="submit" class="btn btn-default" name="action" value="install" onclick="return confirm('Are you sure you want to (re)install this sandbox?');"><span class="glyphicon glyphicon glyphicon-import"></span> Install</button>
            </div>
            <div class="btn-group">
            <button type="submit" class="btn btn-default" name="action" value="download"><span class="glyphicon glyphicon glyphicon-export"></span> Export</button>
            </div>
            <div class="btn-group">
            <button type="submit" class="btn btn-default" name="action" value="delete" onclick="return confirm('Are you sure you want to delete this sandbox?');"><span class="glyphicon glyphicon-remove"></span> Delete</button>
            </div>
            </div>
            </td>

            </form>
            </tr>
        </tbody>
        </table>
            
        </div>
        </div>
        </div>
    <?php } ?>
  </div>
  </div>
</div>