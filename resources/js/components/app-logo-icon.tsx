import { SVGAttributes } from 'react';

export default function AppLogoIcon(props: SVGAttributes<SVGElement>) {
    return (
        <svg {...props} viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            {/* Islamic Star and Crescent with Book */}
            <path
                fillRule="evenodd"
                clipRule="evenodd"
                d="M12 2L14.5 8.5L21 9L16 14L17.5 21L12 18L6.5 21L8 14L3 9L9.5 8.5L12 2Z"
                opacity="0.8"
            />
            <path
                fillRule="evenodd"
                clipRule="evenodd"
                d="M3 16H21V18H3V16ZM5 19H19V21H5V19Z"
                opacity="0.9"
            />
            <circle cx="18" cy="6" r="3" opacity="0.7"/>
        </svg>
    );
}