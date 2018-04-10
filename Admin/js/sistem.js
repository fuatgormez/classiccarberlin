<!-- languageDelete -->
function languageDelete(ID) {

	$.ajax({
		type	:'GET',
		url		:'index.php?page=languageDelete',
		data	:{ID:ID},

		success: function (result) {
			$('#listID'+ID).remove();

			setTimeout(function() {
				toastr.options = {
					closeButton: true,
					progressBar: true,
					showMethod: 'slideDown',
					timeOut: 3000
				};
				toastr.error('Spreche gelöscht!');
			});
		}

	});


}
<!-- languageDelete -->

<!-- imageDelete -->
function imageDelete(ID) {
		$.ajax({
			type	:'GET',
			url		:'index.php?page=imageDelete',
			data	:{one:ID},
			success: function (cevap) {
				var carImage = $('#listID'+ID)
				$(carImage).remove();
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 3000
					};
					toastr.error('Bild gelöscht!');

				});


			}
		});


}
<!-- imageDelete -->

<!-- contactMessageDelete -->
function contactMessageDelete(ID) {

	$.ajax({
		type	:'GET',
		url		:'index.php?page=contactMessageDelete',
		data	:{ID:ID},

		success: function (result) {
				$('#listID'+ID).remove();

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 3000
					};
					toastr.error('Nachricht gelöscht!');
				});
		}

	});


}
<!-- contactMessageDelete -->

<!-- categoryActive -->
function categoryActive_categoryInactive(val,ID) {

    $.ajax({
        type	:'POST',
        url		:'index.php?page=categoryStatus',
        data	:{val:val,ID:ID},
        success: function (result) {

            if(val == "Y"){
                $('#categoryStatus'+ID).html('<i class="fa fa-circle label-primary" title="Kategorie Aktiv"></i>').removeClass().load().addClass('pull-right label label-primary');
                $('#selectedClass'+ID).removeClass().load().addClass('btn text-navy');

                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 22000
                    };
                    toastr.success('<?=$langDB["LANG_KEYWORD"];?>!');
                    //toastr.success('Kategorie aktiv!');

                });

            }else{
                $('#categoryStatus'+ID).html('<i class="fa fa-circle label-danger" title="Kategorie Passiv"></i>').removeClass().load().addClass('pull-right label label-danger');
                $('#selectedClass'+ID).removeClass().load().addClass('btn text-danger');

                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 2000
                    };
                    toastr.warning('Kategorie inaktiv!');

                });
            }
        }
    });

}
<!-- /categoryActive -->

<!-- categoryDelete -->
function categoryDelete(ID) {

    $.ajax({
        type	:'GET',
        url		:'index.php?page=categoryDelete',
        data	:{ID:ID},
        success: function (cevap) {
            $('#listID'+ID).remove();
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 3000
                };
                toastr.error('Kategorie gelöscht!');
            });

        }
    });

}
<!-- categoryDelete -->

<!-- carActive -->
function carActive_carInactive(val,ID) {

	$.ajax({
		type	:'POST',
		url		:'index.php?page=carStatus',
		data	:{val:val,ID:ID},
		success: function (result) {

			if(val == "Y"){
				$('#carStatus'+ID).html('<i class="fa fa-circle label-primary" title="Auto Aktiv"></i>').removeClass().load().addClass('pull-right label label-primary');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-navy');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.success('Auto aktiv!');

				});

			}else{
				$('#carStatus'+ID).html('<i class="fa fa-circle label-danger" title="Auto Passiv"></i>').removeClass().load().addClass('pull-right label label-danger');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-danger');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.warning('Auto inaktiv!');

				});
			}
		}
	});

}
<!-- /carActive -->

<!-- carDelete -->
function carDelete(ID) {

		$.ajax({
			type	:'GET',
			url		:'index.php?page=carDelete',
			data	:{ID:ID},
			success: function (cevap) {
				$('#listID'+ID).remove();
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 3000
					};
					toastr.error('Auto gelöscht!');

				});


			}
		});

}
<!-- carDelete -->

<!-- menuDelete -->
function menuDelete(ID) {

		$.ajax({
			type	:'GET',
			url		:'index.php?page=menuDelete',
			data	:{ID:ID},
			success: function (cevap) {
				$('#listID'+ID).remove();
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 3000
					};
					toastr.error('Menü gelöscht!');

				});


			}
		});

}
<!-- menuDelete -->

<!-- userActive -->
function userActive_userInactive(val,ID) {
	if (ID !=1){
	$.ajax({
		type	:'POST',
		url		:'index.php?page=userStatus',
		data	:{val:val,ID:ID},
		success: function (result) {

			if(val == "Y"){
				$('#userStatus'+ID).html('<i class="fa fa-circle label-primary" title="Mitglied aktiv"></i>').removeClass().load().addClass('pull-right label label-primary');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-navy');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.success('Mitglied aktiv!');

				});

			}else{
				$('#userStatus'+ID).html('<i class="fa fa-circle label-danger" title="Mitglied passiv"></i>').removeClass().load().addClass('pull-right label label-danger');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-danger');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.warning('Mitglied inaktiv!');

				});
			}
		}
	});
	}else{
		setTimeout(function() {
			toastr.options = {
				closeButton: true,
				progressBar: true,
				showMethod: 'slideDown',
				timeOut: 3000
			};
			toastr.error('Bu kullanıcı üzerinde işlem yapamazsınız!');

		});
	}
}
<!-- /userActive -->

<!-- userDelete -->
function userDelete(ID) {
	if(ID !=1){
		$.ajax({
			type	:'GET',
			url		:'index.php?page=userDelete',
			data	:{ID:ID},
			success: function (cevap) {
				$('#listID'+ID).remove();
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 3000
					};
					toastr.error('Mitglied gelöscht!');

				});


			}
		});
	}else{
		setTimeout(function() {
			toastr.options = {
				closeButton: true,
				progressBar: true,
				showMethod: 'slideDown',
				timeOut: 3000
			};
			toastr.error('Bu üyeyi silemezsiniz!');

		});
	}
}
<!-- userDelete -->

<!-- pageActive -->
function pageActive_pageInactive(val,ID) {
	$.ajax({
		type	:'POST',
		url		:'index.php?page=pageStatus',
		data	:{val:val,ID:ID},
		success: function (result) {

			if(val == "Y"){
				$('#pageStatus'+ID).html('<i class="fa fa-circle label-primary" title="Seite Aktiv"></i>').removeClass().load().addClass('pull-right label label-primary');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-navy');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.success('Seite aktiv!');

				});

			}else{
				$('#pageStatus'+ID).html('<i class="fa fa-circle label-danger" title="Seite Passiv"></i>').removeClass().load().addClass('pull-right label label-danger');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-danger');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.warning('Seite inaktiv!');

				});
			}
		}
	});
}
<!-- /pageActive -->

<!-- pageDelete -->
function pageDelete(ID) {
	$.ajax({
		type	:'GET',
		url		:'index.php?page=pageDelete',
		data	:{ID:ID},
		success: function (cevap) {
			$('#listID'+ID).remove();
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 3000
					};
					toastr.error('Seite gelöscht!');

				});


		}
	});
}
<!-- pageDelete -->

<!-- newsActive -->
function newsActive_newsInactive(val,ID) {
	$.ajax({
		type	:'POST',
		url		:'index.php?page=newsStatus',
		data	:{val:val,ID:ID},
		success: function (result) {

			if(val == "Y"){
				$('#newsStatus'+ID).html('<i class="fa fa-circle label-primary" title="Nachrichten Aktiv"></i>').removeClass().load().addClass('pull-right label label-primary');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-navy');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.success('Nachrichten aktiv!');

				});

			}else{
				$('#newsStatus'+ID).html('<i class="fa fa-circle label-danger" title="Nachrichten Passiv"></i>').removeClass().load().addClass('pull-right label label-danger');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-danger');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.warning('Nachrichten inaktiv!');

				});
			}
		}
	});
}
<!-- /newsActive -->
<!-- newsDelete -->
function newsDelete(ID) {
	$.ajax({
		type	:'GET',
		url		:'index.php?page=newsDelete',
		data	:{ID:ID},
		success: function (cevap) {
			$('#listID'+ID).remove();
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 3000
					};
					toastr.error('Nachrichten gelöscht!');

				});


		}
	});
}
<!-- /newsDelete -->

<!-- noticeActive -->
function noticeActive_noticeInactive(val,ID) {
	$.ajax({
		type	:'POST',
		url		:'index.php?page=noticeStatus',
		data	:{val:val,ID:ID},
		success: function (result) {

			if(val == "Y"){
				$('#noticeStatus'+ID).html('<i class="fa fa-circle label-primary" title="Neuigkeiten Aktiv"></i>').removeClass().load().addClass('pull-right label label-primary');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-navy');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.success('Neuigkeiten aktiv!');

				});

			}else{
				$('#noticeStatus'+ID).html('<i class="fa fa-circle label-danger" title="Neuigkeiten Passiv"></i>').removeClass().load().addClass('pull-right label label-danger');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-danger');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.warning('Neuigkeiten inaktiv!');

				});
			}
		}
	});
}
<!-- /noticeActive -->

<!-- noticeDelete -->
function noticeDelete(ID) {
	$.ajax({
		type	:'GET',
		url		:'index.php?page=noticeDelete',
		data	:{ID:ID},
		success: function (cevap) {
			$('#listID'+ID).remove();
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 3000
					};
					toastr.error('Neuigkeiten gelöscht!');

				});


		}
	});
}
<!-- /noticeDelete -->

<!-- videoActive -->
function videoActive_videoInactive(val,ID) {
	$.ajax({
		type	:'POST',
		url		:'index.php?page=videoStatus',
		data	:{val:val,ID:ID},
		success: function (result) {

			if(val == "Y"){
				$('#videoStatus'+ID).html('<i class="fa fa-circle label-primary" title="Video Aktiv"></i>').removeClass().load().addClass('pull-right label label-primary');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-navy');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.success('Video aktiv!');

				});

			}else{
				$('#videoStatus'+ID).html('<i class="fa fa-circle label-danger" title="Video Passiv"></i>').removeClass().load().addClass('pull-right label label-danger');
				$('#selectedClass'+ID).removeClass().load().addClass('btn text-danger');

				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 2000
					};
					toastr.warning('Video passiv!');

				});
			}
		}
	});
}
<!-- /videoActive -->
<!-- videoDelete -->
function videoDelete(ID) {
	$.ajax({
		type	:'GET',
		url		:'index.php?page=videoDelete',
		data	:{ID:ID},
		success: function (cevap) {
			$('#listID'+ID).remove();
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 3000
					};
					toastr.error('Video gelöscht!');

				});


		}
	});
}
<!-- /videoDelete -->

<!-- imageUrl clipboard -->
function imageLinkCopy() {
	new Clipboard('#imageSelectID');
	setTimeout(function() {
		toastr.options = {
			closeButton: true,
			progressBar: true,
			showMethod: 'slideDown',
			timeOut: 3000
		};
		toastr.success('Resmin linkini kopyaladınız!');

	});
}
<!-- /imageUrl clipboard -->

