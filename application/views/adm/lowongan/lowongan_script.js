
$(document).ready(function(){
	
	$('#datatables').DataTable();

	$(".edit").click(function(){


		$("#modal_edit").find(".modal-body").find("#nama_edit").val($(this).data('nama'));
		$("#modal_edit").find(".modal-body").find("#kode_lowongan_edit").val($(this).data('kode_lowongan'));
		$("#modal_edit").find(".modal-body").find("#deskripsi_edit").val($(this).data('deskripsi'));

		$("#modal_edit").find(".modal-body").find("#berakhir_edit").val($(this).data('berakhir'));

		$("#modal_edit").find(".modal-body").find("#id_edit").val($(this).data('id'));
		
		
	});

});