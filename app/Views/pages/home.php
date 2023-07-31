
<?= $this->extend('layout/template');?>

<?= $this->section('content'); ?>

    <h1>Hello World</h1>
    <h4>Tabel User IGR BGR</h4>
    <br>   
    <!-- KODEIGR, RECORDID, USERID, USERPASSWORD, USERLEVEL, STATION, USERNAME, EMAIL, CREATE_BY, CREATE_DT, MODIFY_DT, NIK -->
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">KODEIGR</th>
      <th scope="col">RECORDID</th>
      <th scope="col">USERID</th>
      <th scope="col">USERNAME</th>
      <th scope="col">USERPASSWORD</th>
    </tr>
  </thead>
  <tbody>
      <?php $i = 1; ?>
      <?php foreach($users->getResultArray() as $konek): ?>
        <tr>
           <th scope="row"><?= $i++; ?></th>         
            <td><?= $konek['KODEIGR']; ?></td>
            <td><?= $konek['RECORDID']; ?></td>
            <td><?= $konek['USERID']; ?></td>
            <td><?= $konek['USERNAME']; ?></td>
            <td><?= $konek['USERPASSWORD']; ?></td>
        </tr>
   <?php endforeach; ?>
  </tbody>
</table>

<?= $this->endSection();?>