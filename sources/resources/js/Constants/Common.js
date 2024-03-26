import moment from "moment"

export const VIEW = 'view'
export const EDIT ='edit'
export const DELETE = 'delete'
export const ADD = 'add'

export const TITLE_VIEW = 'Form Detail'
export const TITLE_ADD = 'Form Add'
export const TITLE_EDIT = 'Form Edit'
export const TITLE_DETAIL = 'Form Delete'

export const FIELD_TEXT = 'text'
export const FIELD_IMAGE = 'image'
export const FIELD_SELECT = 'select'
export const FIELD_IMAGES = 'images'
export const FIELD_CHECKBOX = 'checkbox'
export const FIELD_RADIO = 'radio'
export const FIELD_TEXTAREA = 'textarea'
export const FIELD_EDITOR = 'editor'
export const FIELD_DATEPICKER = 'datepicker'
export const FIELD_NUMBER = 'number'

export function dateTimeFormat (date, format = 'YYYY-MM-DD H:mm:ss') {
    return moment(date).format(format)
}
