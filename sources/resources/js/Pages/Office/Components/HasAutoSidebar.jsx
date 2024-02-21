export default function HasAutoSidebar(props) {
    return (
        <>
            {props.posttype &&
                props.posttype.length > 0 &&
                props.posttype.map((item, index) => (
                    <div key={index}>
                        <li className="px-5">
                            <div className="flex flex-row items-center h-8">
                                <div className="text-sm font-light tracking-wide text-gray-500">
                                    {item.name}
                                </div>
                            </div>
                        </li>
                        <li className="ml-2">
                            <a
                                href={route("posttype.create", {'posttype' : item.code})}
                                className="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6"
                            >
                                <span className="inline-flex justify-center items-center ml-4">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        fill="currentColor"
                                        class="bi bi-plus-square"
                                        viewBox="0 0 16 16"
                                    >
                                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                    </svg>
                                </span>
                                <span className="ml-2 text-sm tracking-wide truncate">
                                    Add new
                                </span>
                            </a>
                        </li>
                        <li className="ml-2">
                            <a
                                href={route("posttype.index",  {'posttype' : item.code})}
                                className="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6"
                            >
                                <span className="inline-flex justify-center items-center ml-4">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        fill="currentColor"
                                        class="bi bi-card-list"
                                        viewBox="0 0 16 16"
                                    >
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                                        <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                                    </svg>
                                </span>
                                <span className="ml-2 text-sm tracking-wide truncate">
                                    List
                                </span>
                            </a>
                        </li>
                        {item.hasCategory > 0 && (
                            <li className="ml-2">
                                <a
                                    href={route("category.index",  {'posttype' : item.code})}
                                    className="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6"
                                >
                                    <span className="inline-flex justify-center items-center ml-4">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            fill="currentColor"
                                            class="bi bi-bookmarks-fill"
                                            viewBox="0 0 16 16"
                                        >
                                            <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5z" />
                                            <path d="M4.268 1A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L13 13.768V2a1 1 0 0 0-1-1z" />
                                        </svg>
                                    </span>
                                    <span className="ml-2 text-sm tracking-wide truncate">
                                        Category
                                    </span>
                                </a>
                            </li>
                        )}
                    </div>
                ))}
        </>
    );
}
