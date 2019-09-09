export function $(name) { return document.getElementById(name); }

export function switchLogic(number)
{
    if (number)
        return 0;
    return 1;
}