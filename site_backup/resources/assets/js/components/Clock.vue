<!-- JoinTrainingForm.vue -->
<template>
    <li class="clock">
        <span class="clock__icon">
            <i class="fa fa-clock-o"></i>
        </span>
        <span class="clock__time">
            <span class="clock__time__hours"></span>
            <span class="clock__time__separator">:</span>
            <span class="clock__time__minutes"></span>
            <span class="clock__time__separator">:</span>
            <span class="clock__time__seconds"></span>
        </span>
        <span class="clock__meridiem"></span>
    </li>
</template>

<script>
export default {
    
    props: {
        locale: {
            type: String,
            default() {
                return 'en';
            }
        },
    },
    
    data() {
        return {};
    },
    
    mounted() {
        let $clockHours = $('.clock__time__hours');
        let $clockMinutes = $('.clock__time__minutes');
        let $clockSeconds = $('.clock__time__seconds');
        let $clockMeridiem = $('.clock__meridiem');
        moment.locale(this.locale);
        setInterval(function() {
            let parts = moment().format('LTS').split(' ');
            let timeParts = parts[0].split(':');
            $clockHours.text(timeParts[0]);
            $clockMinutes.text(timeParts[1]);
            $clockSeconds.text(timeParts[2]);
            if (parts.length > 1) {
                $clockMeridiem.text(parts[1]);
            }
        }, 1000);
    }
}
</script>
