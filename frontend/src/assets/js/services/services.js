const getResource = async (urlResource) => {
	// GET запрос возвращает промис http://vmicro.tpu.ru/microscope/rock/test
	const res = await fetch(urlResource);

	if (!res.ok) {
		throw new Error(`Could not fetch ${url}, status: ${res.status}`);
	}

	return await res.json();
};

export { getResource };
