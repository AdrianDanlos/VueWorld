export default{
    data(){
        return{
            errors: null //we store the error information
        }
    },
    methods: {
        errorFor(field) {
            return null !== this.errors && this.errors[field]
              ? this.errors[field]
              : null;
          }
    },
};