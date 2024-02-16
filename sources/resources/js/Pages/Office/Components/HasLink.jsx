export default function HasLink({ link, color, children }) {
    function getColor () {
        switch (color) {
            case 'danger': {
                return 'bg-red-400'
            }
            case 'warning': {
                return 'bg-yellow-400'
            }
            case 'success': {
                return 'bg-green-400'
            }
            default: {
                return 'bg-blue-400'
            }
        }
    }
    return (
        <a
            className={`py-[10px] px-[20px] rounded-md text-white ${getColor()}`}
            href={link}
        >
            {children}
        </a>
    );
}
