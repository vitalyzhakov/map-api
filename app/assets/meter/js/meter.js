$(document).ready(function () {
    $('#meter-electricity_status input').change(function () {
        var $value = parseInt(this.value);

        switch ($value) {
            case 0:
                $('.field-meter-electricity_day').slideUp();
                $('.field-meter-electricity_night').slideUp();
                break;
            case 1:
                $('.field-meter-electricity_day').slideDown();
                $('.field-meter-electricity_day .control-label').html('Электричество');
                
                $('.field-meter-electricity_night').slideUp();
                break;
            case 2:
                $('.field-meter-electricity_day').slideDown();
                $('.field-meter-electricity_day .control-label').html('Электричество день');
                $('.field-meter-electricity_night').slideDown();
                break;

        }
    });
});