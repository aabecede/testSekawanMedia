<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var BASE_URL = `{{ url('') }}`
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    initSelect2()

    function initSelect2() {
        $('.js-select2').select2({
            width: '100%'
        })
        $('.js-select2-tags').select2({
            width: '100%',
            tags: true
        })
    }

    function customValidatorVJs({
        button,
        form,
        load_main_page = true
    }) {
        if (load_main_page == true || load_main_page == 1) {
            $('#main-page-loading').css('display', 'block').css('z-index', '99999')
        }
        $('.invalid-feedback').remove()
        $('.is-invalid').removeClass('is-invalid')
        let is_validated = form.valid()
        let loading = `<i class="fa fa-spinner fa-spin ml-10 hide" id="loading-button"></i>`

        $(button).append(loading)
        $(button).attr('disabled', true)
        $('.invalid-feedback').remove()
        $('.is-invalid').removeClass('is-invalid')
        $("#loading-button").removeClass('hide')

        if (is_validated == false) {
            if ((typeof main_loading != 'undefined' && main_loading == 1) || load_main_page == true) {
                $('#main-page-loading').css('display', 'none')
            }
            $(button).removeAttr('disabled')
            $("#loading-button").remove()
            return Swal.fire({
                icon: 'error',
                title: 'Gagal !',
                text: 'Validasi Tidak Lengkap!',
            })
        }

        return is_validated
    }


    function callSwal({
        type,
        title,
        text,
        url = 0,
        timer = false //fill false / number of seconds
    }) {
        return Swal.fire({
            icon: type,
            title: title,
            html: text,
            timer: timer,
        }).then((result) => {
            if (result.dismiss != '' && !(url == "" || url == 0)) {
                url = String(url)
                if (url !== '0' || url != 0) {
                    window.location.href = url;
                }
            }
        });
    }

    function swalLoading({
        message = `Sedang memproses data ...`
    }) {
        Swal.fire({
            icon: 'warning',
            title: 'Harap menunggu',
            html: message,
            showCancelButton: false,
            allowOutsideClick: false,
            confirmButtonText: ``,
            onOpen: () => {
                Swal.showLoading()
            }
        })
        return Swal;
    }

    function validatorMessageJs({
        message
    }) {
        return callSwal({
            type: 'warning',
            title: 'Validator Error',
            text: message,
            url: 0
        })
    }

    function swalTerjadiKesalahanServer() {
        return Swal.fire({
            icon: 'error',
            title: 'Gagal !',
            text: 'Something went wrong!',
        })
    }
</script>
@stack('js')
