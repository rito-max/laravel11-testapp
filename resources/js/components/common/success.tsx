export default function Success(props: { message: string }) {
    return (
        <div className="text-emerald-600 mx-auto w-5/6 mt-8">
            <p>{props.message}</p>
        </div>
    );
}
