<template>
  <footer class="footer">
    <div class="footer__upper">
      <div class="footer__inner footer__inner--grid">
        <div class="footer__section">
          <h4 class="footer__section-title">Contact the Publisher</h4>
          <ul class="footer__section-list">
            <li class="footer__section-item">
              <a
                href="#"
                class="footer__section-link"
                @click.prevent="modalStore.openModal('login')"
                >Login</a
              >
            </li>
            <li class="footer__section-item">
              <a
                href="#"
                class="footer__section-link"
                @click.prevent="modalStore.openModal('register')"
                >Register</a
              >
            </li>
            <li class="footer__section-item">
              <a href="mailto:#" class="footer__section-link">mike@runo.com</a>
            </li>
            <li class="footer__section-item">
              <RouterLink to="/" class="footer__section-link"
                >+944 450 904 505</RouterLink
              >
            </li>
          </ul>
        </div>
        <div class="footer__section">
          <h4 class="footer__section-title">Explorate</h4>
          <ul class="footer__section-list">
            <li class="footer__section-item">
              <RouterLink to="/" class="footer__section-link"
                >Partners</RouterLink
              >
            </li>
            <li class="footer__section-item">
              <RouterLink to="/" class="footer__section-link"
                >Job Opportunities</RouterLink
              >
            </li>
            <li class="footer__section-item">
              <RouterLink to="/" class="footer__section-link"
                >Advertise</RouterLink
              >
            </li>
            <li class="footer__section-item">
              <RouterLink to="/" class="footer__section-link"
                >Membership</RouterLink
              >
            </li>
          </ul>
        </div>
        <div class="footer__section">
          <h4 class="footer__section-title">Headquarter</h4>
          <ul class="footer__section-list">
            <li class="footer__section-item">
              <RouterLink to="/" class="footer__section-link"
                >191 Middleville Road, NY 1001, Sydney Australia
              </RouterLink>
            </li>
          </ul>
        </div>
        <div class="footer__section">
          <h4 class="footer__section-title">Headquarter</h4>
          <ul class="footer__section-list">
            <li class="footer__section-item">
              <RouterLink to="/" class="footer__section-link"
                >191 Middleville Road, NY 1001, Sydney Australia
              </RouterLink>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer__bottom">
      <div class="footer__inner footer__inner--bottom">
        <p class="footer__bottom-text footer__bottom-text--copyright">
          2021 | RUNO Publisher Studio
        </p>
        <p class="footer__bottom-text footer__bottom-text--subscribe">
          Subscribe
        </p>
      </div>
    </div>
  </footer>
</template>

<script>
import { mapStores } from 'pinia'
import { useModalStore } from '@/store/Modal'
export default {
  computed: {
    ...mapStores(useModalStore)
  }
}
</script>

<style>
</style>