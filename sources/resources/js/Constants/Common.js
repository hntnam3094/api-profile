import moment from "moment"

export const VIEW = 'view'
export const EDIT ='edit'
export const DELETE = 'delete'
export const ADD = 'add'

export const TITLE_VIEW = 'Form Detail'
export const TITLE_ADD = 'Form Add'
export const TITLE_EDIT = 'Form Edit'
export const TITLE_DETAIL = 'Form Delete'


export function dateTimeFormat (date, format = 'YYYY-MM-DD H:mm:ss') {
    return moment(date).format(format)
}
