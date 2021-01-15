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

    $('#new_user').click(() => {
        $('#title').html('Nuevo');
        action = 'create';
        $('#password').prop({required: true});
        $('#id_user').val('');
        $('#user_modal').modal('show');
    });

    $('#user_modal').on('hidden.bs.modal', () => {
        $('#user_form')[0].reset();
    });

    $('#user_form').submit((e) => {
        e.preventDefault();

        let info = {
            id: $('#id_user').val(),
            user_type_id: $('#user_type_id').val(),
            alias: $('#alias').val(),
            email: $('#email').val(),
        }

        if( $('#password').val() !== '' )
            info['password'] = $('#password').val();

        const method = ( action === 'create' ) ? 'POST' : 'PUT';

        const insert = call(JSON.stringify(info), URL+'user/'+action, method);

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

    $('#users_table').on('click', 'button.delete', function() {
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
        
                const deleteCall = call(JSON.stringify(info), URL+'user/delete', 'DELETE');
        
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
            }
        });

    });
    
    $('#users_table').on('click', 'button.update', function() {
        $('#title').html('Editar')
        const id = $(this).data('id');

        const info = {
            id: id
        }

        const get = call(JSON.stringify(info), URL+'user/detail', 'POST');

        get.done((json_response) => {

            Swal.close();

            if( json_response.status === 201 ){
                const data = json_response.result;
                $('#id_user').val(data.id);
                $('#user_type_id').val(data.user_type_id);
                $('#alias').val(data.alias);
                $('#email').val(data.email);

                action = 'update';

                $('#password').prop({required: false});
                $('#user_modal').modal('show');

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