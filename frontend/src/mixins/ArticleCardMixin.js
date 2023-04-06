import { parseISO, format } from 'date-fns';

export default {
    computed: {
        shortContent() {
            return `${this.article.content.replace(/(<([^>]+)>)/gi, "").slice(0, 100)}...`
        },
        dateFormatted() {
            const parse = parseISO(this.article.created_at)
            return format(parse, 'dd MMMM yyyy')
        }
    }
}
