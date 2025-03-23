type ButtonProps = {
    onClick: () => void;
    color: string;
    text: string;
};

export default function Button(props: ButtonProps) {
    return (
        <button
            onClick={props.onClick}
            className={
                "rounded-full text-white px-5 py-3 text-sm bg-" + props.color
            }
        >
            {props.text}
        </button>
    );
}
