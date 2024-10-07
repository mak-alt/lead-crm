<template>
  <div v-if="$page.props.flash.success && show" class="toastify show on bg-success toastify-center toastify-top" aria-live="polite" style="transform: translate(0px, 0px); top: 30px;">{{ $page.props.flash.success }}</div>
  <div v-if="$page.props.flash.error && show" class="toastify on bg-danger toastify-center toastify-top" aria-live="polite" style="transform: translate(0px, 0px); top: 15px;">{{ $page.props.flash.error }}</div>
  
</template>

<style scoped>
  .toastify.show {
    visibility: visible; /* Show the snackbar */
    /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
    However, delay the fade out process for 2.5 seconds */
    -webkit-animation: fadein 0.2s, fadeout 0.5s 1.5s;
    animation: fadein 0.2s, fadeout 0.5s 1.5s;
  }

  /* Animations to fade the snackbar in and out */
  @-webkit-keyframes fadein {
    from {top: 0; opacity: 0;}
    to {top: 30px; opacity: 1;}
  }

  @keyframes fadein {
    from {top: 0; opacity: 0;}
    to {top: 30px; opacity: 1;}
  }

  @-webkit-keyframes fadeout {
    from {top: 30px; opacity: 1;}
    to {top: 0; opacity: 0;}
  }

  @keyframes fadeout {
    from {top: 30px; opacity: 1;}
    to {top: 0; opacity: 0;}
  }
</style>

<script>

export default {
  data() {
    return {
      show: false,
    }
  },
  watch: {
    '$page.props.flash': {
      handler() {
        this.show = true
        setTimeout(() => this.show = false, 4000)
      },
      deep: true,
    },
  },
  methods: {
    showMessage() {
      if(this.$page.props.flash){
        this.show = true;
      }
    }
  },
  created() {
    this.showMessage();
    setTimeout(() => this.show = false, 4000);
  }
}
</script>
