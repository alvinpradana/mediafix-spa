<template>
    <form @submit.prevent="store">
        <div class="bg-gray-dark p-3 rounded mt-3">
            <div class="row">
                <div style="width:200px; height:200px" class="border rounded-circle mx-auto d-block mb-2">
                    <input @input="changeImage" type="file" class="d-none" ref="file">
                    <img v-if="preview" :src="preview" alt="Images" class="rounded-circle mx-auto d-block w-100 h-100"/>
                </div>
            </div>
            <div class="dropdown-divider mx-5"></div>
            <div class="row justify-content-center py-2">
                <a type="button" @click.prevent="choose()" class="text-primary"><u>Choose</u></a>
            </div>
        </div>
        <div v-if="chooseImage" class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 rounded mt-3">
            <div class="col-md-6">
                <button type="submit" class="btn btn-lg btn-block btn-outline-success">
                    Save
                </button>
            </div>
            <div class="col-md-6">
                <button @click="cancel()" type="button" class="btn btn-lg btn-block btn-outline-danger">
                    Cancel
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
export default {
    data () {
        return {
            chooseImage: false,
            preview: null
        }
    },
    setup () {
        const formImage = useForm({
            image: null,
        })
        return { formImage }
    },
    methods: {
        choose () {
            this.$refs.file.click();
            this.chooseImage = true
        },
        cancel () {
            this.chooseImage = false
            this.preview = null
        },
        change (e) {
            this.$emit("input", e.target.files[0])
        },
        changeImage () {
            let file = this.$refs.file
            let imgInput = file.files

            if (imgInput && imgInput[0]) {
                let reader = new FileReader
                reader.onload = e => {
                    this.preview = e.target.result
                }
                reader.readAsDataURL(imgInput[0])
                this.$emit('file', imgInput[0])
            }
        },
        store () {
            if (this.$refs.file) {
                this.formImage.image = this.$refs.file.files[0]
            }
            Inertia.post(route('user.image'), this.formImage, {
                onSuccess: () => this.chooseImage = false
            })
        }
    },
}
</script>