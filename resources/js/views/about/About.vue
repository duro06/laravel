<template>
  <div class="about">
    <div class="has-text-centered">
      <div class="avatar">
        <img :src="logo" alt="logo" />
      </div>
    </div>
    <h1><b>Pengertian Umum Koperasi</b></h1>
    <p>
      <B>Koperasi</B> adalah badan usaha yang dimiliki dan dijalankan oleh anggotanya untuk memenuhi
      kebutuhan bersama di bidang ekonomi, sosial dan budaya. Sedangkan pengertian koperasi yang
      lebih formal adalah sesuai dengan Undang Undang No. 17 Tahun 2012 pasal 1, yaitu:
    </p>
    <p>
      Koperasi merupakan badan hukum yang didirikan oleh orang perseorangan atau badan hukum
      koperasi, dengan pemisahan kekayaan para anggotanya sebagai modal untuk menjalankan usaha,
      yang memenuhi aspirasi dan kebutuhan bersama di bidang ekonomi, sosial, dan budaya sesuai
      dengan nilai dan prinsip koperasi.
    </p>
    <h1><b>Tentang Koperasi Wanita Teratai</b></h1>
    <p>
      <b>Kopwan Teratai</b> pertama kali didirikan pada tahun 2009. Pertama kali didirikan dengan
      nama Koppuan Teratai. Akronim dari Koperasi Perempuan, yang kemudian nama Koppuan berubah
      menjadi Kopwan, akronim dari Koperasi Wanita.
    </p>
    <p>
      Jika diperhatikan dari nama, maka dapat disimpilkan bahwa Koperasi ini beranggotakan para
      wanita. Sebagaimana ini sejalan dengan tujuan pemerintah Provinsi Jawa Timur saat itu. Yaitu
      agar para wanita di Jawa Timur memiliki ketahanan Ekonomi dan bisa bersama dengan suami
      membangun ekonomi keluarga.
    </p>
  </div>
</template>

<script>
export default {
  name: 'about',
  computed: {
    logo() {
      return this.$store.getters['auth/storageUrl'] + '/galleries_images/logo.png';
    }
  }
};
</script>

<style scoped>
p {
  margin: 10px 5px;
}
</style>
