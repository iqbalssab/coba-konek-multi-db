
<?= $this->extend('layout/template');?>

<?= $this->section('content'); ?>
    <h1>Preview Transaksi Kasir</h1>
<div class="container">
    <table class="table">
  <thead>
      <tr>
          <th scope="col">#</th>
          <th scope="col">Nama Kasir</th>
          <th scope="col">Kassa</th>
          <th scope="col">Total Transaksi</th>
          <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
      <?php $i=1; ?>
      <?php foreach($transactions->getResultArray() as $transaksi): ?>
    <tr>
      <th scope="row"><?= $i++; ?></th>
      <td><?= $transaksi['NAMA_KASIR']; ?></td> 
      <td><?= $transaksi['KASSA']; ?></td>
      <td><?= number_to_currency($transaksi['TOTAL_TRANSAKSI'], 'IDR') ; ?></td>
      <td><?= $transaksi['STATUS']; ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
    
 
<?= $this->endSection();?>