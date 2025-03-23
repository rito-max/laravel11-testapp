export default function Error(props: { message: string }) {
    return (
        <div className="mx-auto w-5/6 mt-8">
            <ul>
                <li className="text-red-400 mb-3 list-none">{props.message}</li>
            </ul>
        </div>
    );
}
