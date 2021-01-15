$(function(){

    var action = 'create';

    function call(info, url, method){
        return $.ajax({
            url: url,
            method: method,
            dataType: "json",
            data: info,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function (){
                Swal.fire({
                    title: 'Cargando...',
                    allowOutsideClick:false,
                    onOpen: function (){
                        swal.showLoading()
                    }
                  })
            }
        })
    }

    $('#new_type').click(() => {
        $('#title').html('Nuevo');
        action = 'create';
        $('#id').val('');
        $('#type_modal').modal('show');
    });

    $('#type_modal').on('hidden.bs.modal', () => {
        $('#type_form')[0].reset();
    });

    $('#type_form').submit((e) => {
        e.preventDefault();

        let info = {
            id: $('#id').val(),
            name: $('#name').val(),
            description: $('#description').val(),
            is_admin: $('#is_admin').is(':checked') ? true : false
        }

        const method = ( action === 'create' ) ? 'POST' : 'PUT';

        const insert = call(JSON.stringify(info), URL+'usertype/'+action, method);

        insert.done((json_response) => {

            Swal.close();

            if( json_response.status === 201 ){
                Swal.fire({
                    title: 'Aviso',
                    text: json_response.message,
                    icon: 'success',
                    confirmButtonText: 'Continuar'
                }).then(() => {
                    location.reload();
                });
            }else{
                console.log(json_response);
                Swal.fire({
                    title: 'Aviso',
                    text: json_response.message,
                    icon: 'info',
                    confirmButtonText: 'Continuar'
                });
            }
        });

        insert.fail((json_response) => {
            Swal.close();
            console.error(json_response);
            Swal.fire({
                title: 'Error',
                text: 'Error en la petición. Intente de nuevo.',
                icon: 'error',
                confirmButtonText: 'Continuar'
            }).then(() => {
                location.reload();
            });
        });
    });

    $('#types_table').on('click', 'button.delete', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Confirmación',
            icon: 'info',
            html:
            '¿Eliminar registro seleccionado?',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Continuar',
            cancelButtonText: 'Cancelar',
        }).then( (res) => {
            if( res.value ){
                const info = {
                    id: id
                }
        
                const deleteCall = call(JSON.stringify(info), URL+'usertype/delete', 'DELETE');
        
                deleteCall.done((json_response) => {
        
                    Swal.close();
        
                    if( json_response.status === 201 ){
                        Swal.fire({
                            title: 'Aviso',
                            text: json_response.message,
                            icon: 'success',
                            confirmButtonText: 'Continuar'
                        }).then(() => {
                            location.reload();
                        });
                    }else{
                        console.log(json_response);
                        Swal.fire({
                            title: 'Aviso',
                            text: json_response.message,
                            icon: 'info',
                            confirmButtonText: 'Continuar'
                        });
                    }
                });
        
                deleteCall.fail((json_response) => {
                    Swal.close();
                    Swal.fire({
                        title: 'Error',
                        text: json_response.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'Continuar'
                    }).then(() => {
                        location.reload();
                    });
                });
            }
        });

    });
    
    $('#types_table').on('click', 'button.update', function() {
        $('#title').html('Editar')
        const id = $(this).data('id');

        const info = {
            id: id
        }

        const get = call(JSON.stringify(info), URL+'usertype/detail', 'POST');

        get.done((json_response) => {

            Swal.close();

            if( json_response.status === 201 ){
                const data = json_response.result;
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#description').val(data.description);
                console.log(data.is_admin)
                $('#is_admin').prop('checked', data.is_admin == 1 ? true : false);
                

                action = 'update';

                $('#type_modal').modal('show');

            }else{
                console.log(json_response);
                Swal.fire({
                    title: 'Aviso',
                    text: json_response.message,
                    icon: 'info',
                    confirmButtonText: 'Continuar'
                });
            }
        });

        get.fail((json_response) => {
            Swal.close();
            console.error(json_response);
            Swal.fire({
                title: 'Error',
                text: 'Error en la petición. Intente de nuevo.',
                icon: 'error',
                confirmButtonText: 'Continuar'
            }).then(() => {
                location.reload();
            });
        });

    });
});