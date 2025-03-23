function getCsrfToken(): string | undefined {
    const meta = document.querySelector<HTMLMetaElement>(
        'meta[name="csrf-token"]'
    );
    return meta?.content;
}

export async function sendDeleteRequest(url: string) {
    const csrfToken = getCsrfToken();
    if (!csrfToken) {
        console.error("CSRF token not found!");
        return false;
    }

    try {
        const response = await fetch(url, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken, // CSRFトークンをヘッダーにセット
            },
        });

        return response.ok;
    } catch (error) {
        console.error(error);
        return false;
    }
}
