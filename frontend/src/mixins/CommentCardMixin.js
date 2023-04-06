import { parseISO, format } from 'date-fns';

export default {
    computed: {
        dateFormatted() {
            const parse = parseISO(this.comment.created_at)
            return format(parse, 'dd MMMM yyyy')
        }
    }
}