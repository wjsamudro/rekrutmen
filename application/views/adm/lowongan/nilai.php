				<div class="box span12">
					<div class="box-header well" data-original-title>
						
					</div>
					<div class="box-content">
					<h2>Tabel Alternatif dan Peringkat<a href='<?php echo site_url("administrasi/tambah_nilai/$id_lowongan")?>' id='input_nilai' class='btn btn-info pull-right'> Tambah Alternatif </a></h2><hr>
					<?php if( $this->session->flashdata('error') != "" ){ ?>
						<div class="alert alert-warning alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>Warning!</strong> <?php echo $this->session->flashdata('error'); ?>
						</div>
						<?php } 
						if( $this->session->flashdata('success') != '' ){ ?>
						<div class="alert alert-success alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <?php echo $this->session->flashdata('success') ?>
						</div>
						<?php }?>
<!-- Pesan Sukses -->
					

						
                    <div class='clearfix'></div>
                    <a href='#' onClick="window.open('<?php echo site_url("administrasi/cetak_hasil/".$id_lowongan) ?>', '_blank');" class='btn btn-danger pull-right'><i class='icon-print icon-white'></i> cetak</a><br><br>

					<table class='table table-bordered' id='datatables'>
						<thead>
						<tr style='background:#c0c0c0'>
							<td>Peringkat</td>
							<td>No Peserta</td>
							<td>Nama</td>
							<td>Tanggal Lahir</td>
							<td>Nilai Ahp</td>
							<td style='text-align:center'>Aksi</td>
						</tr>
						</thead>
						<tbody>
							<?php
$i=1;
foreach ($peserta as $l) {
	echo "<tr>";
	echo "
		<td>".$i."</td>
		<td>".$l->no_peserta."</td>
		<td>".$l->nama_peserta."</td>
		<td>".$l->tgl_lahir."</td>
		<td>".$l->nilai_ahp."</td>
		<td style='text-align:center'><a href='".site_url("administrasi/alternatif_hapus/".$l->id."/".$id_lowongan)."' id='hapus' class=''> Hapus </a> - 
		<a href='".site_url("administrasi/alternatif_edit/".$l->id."/".$id_lowongan)."' id='hapus' class=''> Edit </a> - 
		<a href='".site_url("administrasi/alternatif_detail/".$l->no_peserta."/".$id_lowongan)."' id='detail' class=''> Detail </a></td>

	"; 
	echo "</tr>";
	$i++;
}


							?>
						</tbody>


					</table>

<br><br>
					</div>
				</div><!--/span-->

<script type="text/javascript">
$(document).ready(function(){

	

});
</script>