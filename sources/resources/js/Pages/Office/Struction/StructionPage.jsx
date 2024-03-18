import { DeleteIcon, EditIcon, PlusIcon, ViewIcon } from "@/Icons";
import OfficeLayout from "@/Layouts/OfficeLayout";
import { Head, router } from "@inertiajs/react";
import { Table, Button } from "flowbite-react";
import HasLink from "../Components/HasLink";
import DefaultStatus from "../Components/Status/DefaultStatus";
import { dateTimeFormat } from "@/Constants/Common";
import HasPagination from "../Components/HasPagination";
import { useForm } from "react-hook-form";
import SearchFormGeneration from "../Components/SearchFormGeneration";

export default function StructionPage({
    id,
    data,
    islist,
    pageCode,
    code,
    form = [],
    params = [],
}) {
    const {
        register: registerRHF,
        handleSubmit: handleSubmitRHF,
        watch: watchRHF,
        control: controlRHF,
        unregister: unregisterRHF,
        setValue: setValueRHF,
    } = useForm({ defaultValues: params });

    function onSubmit(data) {
        let params = {
            id: id,
            is_list: 1,
        };

        Object.assign(params, data);
        window.location.href = route("structionpages.detail", params);
    }

    function deleteStructionDetail(id) {
        if (confirm("Are you sure?") == true) {
            router.delete(route("structionpages.delete", { id: id }));
        }
    }

    function renderField(obj, key) {
        if (key === "image") {
            return (
                <img
                    src={`${obj[key]}`}
                    className="w-[100%] h-[80px] rounded-sm object-cover"
                />
            );
        }
        return obj[key];
    }

    return (
        <OfficeLayout>
            <Head title="Struction page" />
            {!islist && (
                <div className="mb-[20px] flex justify-end">
                    <HasLink
                        color="success"
                        link={route("structionpages.create", {
                            page_code: pageCode,
                            code: code,
                        })}
                    >
                        <PlusIcon />
                    </HasLink>
                </div>
            )}
            {!islist && (
                <form
                    onSubmit={handleSubmitRHF(onSubmit)}
                    className="flex items-center gap-x-[20px]"
                >
                    <SearchFormGeneration
                        form={form.search}
                        register={registerRHF}
                        watch={watchRHF}
                        control={controlRHF}
                        unregister={unregisterRHF}
                        setValue={setValueRHF}
                    />

                    {form.search && form.search.length > 0 && (
                        <Button
                            type="submit"
                            color="success"
                            className="h-[50px] w-[50px]"
                        >
                            <ViewIcon />
                        </Button>
                    )}
                </form>
            )}

            <div className="overflow-x-auto">
                <Table hoverable>
                    <Table.Head className="text-center">
                        <Table.HeadCell className="w-[30px]">ID</Table.HeadCell>
                        {islist == 1 && (
                            <>
                                <Table.HeadCell>Title</Table.HeadCell>
                                <Table.HeadCell>PageCode</Table.HeadCell>
                            </>
                        )}

                        {!islist && (
                            <>
                                {form.list &&
                                    form.list.length > 0 &&
                                    form.list.map((itemList) => (
                                        <Table.HeadCell>
                                            {itemList.name}
                                        </Table.HeadCell>
                                    ))}
                                <Table.HeadCell>Status</Table.HeadCell>
                                <Table.HeadCell>Sequence</Table.HeadCell>
                                <Table.HeadCell>Created at</Table.HeadCell>
                            </>
                        )}

                        <Table.HeadCell className="w-[200px]">
                            Action
                        </Table.HeadCell>
                    </Table.Head>
                    <Table.Body className="divide-y">
                        {data.data.map((item, key) => (
                            <Table.Row
                                key={key}
                                className="bg-white dark:border-gray-700 dark:bg-gray-800 text-center"
                            >
                                <Table.Cell className="whitespace-nowrap font-medium text-gray-900 dark:text-white">
                                    {key + 1}
                                </Table.Cell>
                                {islist == 1 && (
                                    <>
                                        <Table.Cell>{item.title}</Table.Cell>
                                        <Table.Cell>{item.pageCode}</Table.Cell>
                                    </>
                                )}

                                {!islist && (
                                    <>
                                        {form.list &&
                                            form.list.length > 0 &&
                                            form.list.map((itemList) => (
                                                <Table.Cell>
                                                    {renderField(
                                                        item,
                                                        itemList.key
                                                    )}
                                                </Table.Cell>
                                            ))}
                                        <Table.Cell>
                                            <DefaultStatus
                                                value={item.status}
                                            />
                                        </Table.Cell>
                                        <Table.Cell>{item.sequence}</Table.Cell>
                                        <Table.Cell>
                                            {dateTimeFormat(item.created_at)}
                                        </Table.Cell>
                                    </>
                                )}

                                <Table.Cell className="flex gap-[5px] justify-center">
                                    {item.singleRow == 0 && (
                                        <>
                                            <HasLink
                                                link={route(
                                                    "structionpages.detail",
                                                    {
                                                        id: item.id,
                                                        is_list: islist,
                                                    }
                                                )}
                                            >
                                                <ViewIcon />
                                            </HasLink>
                                            <HasLink
                                                link={route(
                                                    "structionpages.edit",
                                                    {
                                                        id: item.id,
                                                        is_list: islist,
                                                    }
                                                )}
                                                color="warning"
                                            >
                                                <EditIcon />
                                            </HasLink>
                                        </>
                                    )}

                                    {item.singleRow == 1 && (
                                        <>
                                            <HasLink
                                                link={route(
                                                    "structionpages.single_detail",
                                                    {
                                                        id: item.id,
                                                    }
                                                )}
                                            >
                                                <ViewIcon />
                                            </HasLink>
                                            <HasLink
                                                link={route(
                                                    "structionpages.single_edit",
                                                    {
                                                        id: item.id,
                                                    }
                                                )}
                                                color="warning"
                                            >
                                                <EditIcon />
                                            </HasLink>
                                        </>
                                    )}

                                    {!islist && (
                                        <>
                                            <HasLink
                                                link={route(
                                                    "structionpages.detail",
                                                    {
                                                        id: item.id,
                                                    }
                                                )}
                                            >
                                                <ViewIcon />
                                            </HasLink>
                                            <HasLink
                                                link={route(
                                                    "structionpages.edit",
                                                    {
                                                        id: item.id,
                                                    }
                                                )}
                                                color="warning"
                                            >
                                                <EditIcon />
                                            </HasLink>
                                            <Button
                                                link="#"
                                                className="bg-red-400"
                                                onClick={() =>
                                                    deleteStructionDetail(
                                                        item.id
                                                    )
                                                }
                                            >
                                                <DeleteIcon />
                                            </Button>
                                        </>
                                    )}
                                </Table.Cell>
                            </Table.Row>
                        ))}
                    </Table.Body>
                </Table>
                <div>
                    <HasPagination data={data} />
                </div>
            </div>
        </OfficeLayout>
    );
}
