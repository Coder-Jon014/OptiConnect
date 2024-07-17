import { Children, forwardRef, useRef } from 'react';

export default forwardRef(function SelectInput({ className = '', isFocused = false, children, ...props }, ref) {
    const input = ref ? ref : useRef();


    return (
        <select
            {...props}
            className={
                'py-1 px-2 rounded border border-gray-900 dark:border-gray-700 text-sm focus:outline-none focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 ' +
                className
            }
            ref={input}
        >
            {children}
        </select>
    );
});


