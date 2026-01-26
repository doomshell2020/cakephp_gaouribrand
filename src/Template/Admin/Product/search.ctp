<table  class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th width="5%">S.No</th>
                <th width="12%">Product Name</th>
                <th width="12%">Brand Name</th>
                <th width="12%">Measurement</th>
                <th width="12%">HSN</th>
                <th width="12%">Total Sales</th>
                <?php 
                $role_id = $this->request->session()->read('Auth.User.role_id');
                if ($role_id == 1) { ?>
                  <th width="12%">Location</th>
                <?php } ?>
                <th width="8%">Created</th>
                <th width="8%">Status</th>

              </tr>
            </thead>
            <tbody>
              <?php
              $page = $this->request->params['paging'][$this->request->params['Products']]['page'];
              $limit = $this->request->params['paging'][$this->request->params['Products']]['perPage'];
              $counter = ($page * $limit) - $limit;

              if (isset($Products) && !empty($Products)) {
                foreach ($Products as $product) { //pr($product); die; 
              ?>
                  <tr>
                    <td><?php echo $counter + 1; ?></td>
                    <td><?php echo ucfirst(strtolower($product['name'])); ?> <br> </td>
                    <td><?php echo ucfirst(strtolower($product['brand_name'])); ?></td>
                    <td><?php echo ucfirst(strtolower($product['measurement'])); ?></td>
                    <td><?php echo $product['hsn']; ?></td>
                    <td> ₹ <?php echo sprintf('%.2f', $product['sum']);
                            ?></td>
                    <?php if ($role_id == 1) { ?>
                      <td><?php 
                      echo Ucfirst($product['locality']);
                       ?></td>
                    <?php } ?>
                    <td><?php echo date('d-m-Y', strtotime($product['created'])); ?></td>
                    <td>
                      <?php if ($product['status'] == 'Y') {
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $product['id'], 'N'
                        ], ['title' => 'Active', 'class' => 'fa fa-check-circle', 'style' => 'font-size: 21px !important; margin-left: 12px; color: #36cb3c;']);
                      } else {
                        echo $this->Html->link('', [
                          'action' => 'status', $product['id'], 'Y'
                        ], ['title' => 'Inactive', 'class' => 'fa fa-times-circle-o', 'style' => 'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                      } ?>
                      <?php echo $this->Html->link(__(''), ['action' => 'edit', $product['id']], array('class' => 'fa fa-pencil-square-o fa-lg', 'title' => 'Edit', 'style' => 'font-size: 20px !important; margin-left: 12px;')) ?>
                      <?php if ($role_id == 1) {
                        // echo $this->Html->link('', ['action' => 'delete', $product['id']], ['title' => 'Delete', 'class' => 'fa fa-trash', 'style' => 'color:#FF0000; margin-left: 13px; font-size: 19px !important;', "onClick" => "javascript: return confirm('Are you sure do you want to delete this Product')"]);
                      } ?>
                    </td>
                  </tr>
              <?php $counter++;
                }
              } ?>
            </tbody>
          </table>