import {$} from '../lib.js';

export function send_comment(id)
{
    const textarea_elem = $('comment-textarea-' + id);

    if (textarea_elem.value.length > 10)

}
