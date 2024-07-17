import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function TextInput({ type = 'text', className = '', isFocused = false, ...props }, ref) {
    const input = ref ? ref : useRef();

    useEffect(() => {
        if (isFocused) {
            input.current.focus();
        }
    }, []);

    return (
        <input
            {...props}
            type={type}
            className={
                'py-1.5 px-2 rounded border border-gray-900 focus:border-indigo-600 focus:ring-indigo-500 shadow-sm ' +
                className
            }
            ref={input}
        />
    );
});


