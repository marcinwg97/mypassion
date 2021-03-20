<template>
  <main-layout>
    <h1 class="text-center" style="font-weight: 300">Formularz kontaktowy</h1>
    <div class="row justify-content-center">
      <div class="col-5 justify-content-center">
        <div
          id="success"
          style="display: none"
          class="alert alert-success"
          role="alert"
        ></div>
      </div>
    </div>
    <div class="col-12">
      <div class="row justify-content-center col-12">
        <form class="form-contact" @submit.prevent="addNewMessage">
          <label for="email">Adres e-mail:</label>
          <input type="email" name="email" id="email" v-model="email" />
          <label for="title">Temat:</label>
          <input type="text" name="title" id="title" v-model="title" />
          <label for="contents">Treść:</label>
          <textarea
            name="contents"
            id="contents"
            rows="5"
            v-model="contents"
          ></textarea>
          <button type="submit" class="button-form">Wyślij</button>
        </form>
      </div>
    </div>
  </main-layout>
</template>

<script>
import MainLayout from "@views/layout/Main";
export default {
  data() {
    return {
      email: "",
      title: "",
      contents: ""
    };
  },
  components: {
    MainLayout
  },
  methods: {
    addNewMessage() {
      axios
        .post("/api/messages", {
          email: this.email,
          title: this.title,
          contents: this.contents
        })
        .then(response => {
          $("#success").css("display", "block");
          $("#success").html(response.data.message);
        });
    }
  }
};
</script>
