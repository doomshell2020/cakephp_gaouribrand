<div class="content-wrapper">
  <section class="content-header">
    <h1>
      FAQ Question
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/faq">FAQ</a></li>
    </ol>
  </section> <!-- content header -->

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <!-- Searching  -->
            <?php echo $this->Flash->render();
            // pr($ques);die;
            ?>
            <?php $role_id = $this->request->session()->read('Auth.User.role_id');  ?>
            <script>
              $(document).ready(function() {
                $("#Mysubscriptions").bind("submit", function(event) {
                  $('.lds-facebook').show();
                  $.ajax({
                    async: true,
                    data: $("#Mysubscriptions").serialize(),
                    dataType: "html",
                    type: "POST",
                    url: "<?php echo ADMIN_URL; ?>faq/search",
                    success: function(data) {
                      $('.lds-facebook').hide();
                      $("#example2").html(data);
                    },
                  });
                  return false;
                });
              });
            </script>

            <?php echo $this->Form->create('Mysubscriptions', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscriptions', 'class' => 'form-horizontal')); ?>

            <div class="form-group">
              <div class="col-sm-3">
                <?php echo $this->Form->input('category', array('class' =>
                'form-control branch', 'id' => 'category', 'label' => false, 'options' => $ques, 'empty' => '--Select Catagories--', 'autofocus')); ?>
              </div>

              <div class="col-sm-1">
                <label for="inputEmail3" class="control-label" style="color:white">Search</label>
                <input type="submit" style="background-color:#00c0ef;" id="Mysubscriptions" class="btn btn4 btn_pdf myscl-btn date" value="Search">
              </div>

            </div>
            <?php echo $this->Form->end(); ?>
          </div>
        </div>

        <div class="box">
          <div class="box-header">
            <?php echo $this->Flash->render(); ?>
            <a href="<?php echo SITE_URL; ?>admin/faq/question_add">
              <button class="btn btn-success pull-right m-top10" style="margin-left:10px"><i class="fa fa-plus" aria-hidden="true"></i>
                Add FAQ Question </button></a>
          </div>
          <div class="box-body">
            <table class="table table-bordered table-striped" width="100%" id="example2">
              <thead>
                <tr>
                  <th width="5%">S.No</th>
                  <th width="5%">FAQ Category</th>
                  <th width="15%">Question</th>
                  <th width="15%">Answer</th>
                  <th width="8%">Created</th>
                  <th width="8%">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $page = $this->request->params['paging'][$this->request->params['controller']]['page'];
                $limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
                $counter = ($page * $limit) - $limit + 1;
                if (isset($faq_cat_question) && !empty($faq_cat_question)) {

                  foreach ($faq_cat_question as $faq) { //pr($faq);die; 
                ?>
                    <tr>
                      <td><?php echo $counter;  ?></td>
                      <td><?php echo $faq['faq']['name'];  ?></td>
                      <td><?php echo $faq['question'];  ?></td>
                      <td><?php echo $faq['answer'];  ?></td>
                      <td><?php echo date('d M Y', strtotime($faq['created'])); ?></td>
                      <td>
                        <?php if ($faq['status'] == 'Y') {
                          echo $this->Html->link('', [
                            'action' => 'question_status',
                            $faq->id, 'N'
                          ], ['title' => 'Active', 'class' => 'fa fa-check-circle', 'style' => 'font-size: 21px !important; margin-left: 12px;color: #36cb3c;']);
                        } else {
                          echo $this->Html->link('', [
                            'action' => 'question_status', $faq->id, 'Y'
                          ], ['title' => 'Inactive', 'class' => 'fa fa-times-circle-o', 'style' => 'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                        } ?>

                        <?php echo $this->Html->link(__(''), ['action' => 'question_edit', $faq->id,], array('class' => 'fa fa-pencil-square-o fa-lg', 'title' => 'Edit', 'style' => 'font-size: 20px !important; margin-left: 12px;')) ?>

                        <?php echo $this->Html->link('', ['action' => 'question_delete', $faq->id], ['title' => 'Delete', 'class' => 'fa fa-trash', 'style' => 'color:#FF0000; margin-left: 13px; font-size: 19px !important;', "onClick" => "javascript: return confirm('Are you sure do you want to delete this FAQ Question?')"]); ?>

                      </td>
                    </tr>
                <?php $counter++;
                  }
                } ?>
              </tbody>
            </table>
            <?php echo $this->element('admin/pagination'); ?>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->

</div>
<!-- /.   content-wrapper -->