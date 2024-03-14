import OfficeLayout from "@/Layouts/OfficeLayout";
import { Button, Table } from "flowbite-react";
import { dateTimeFormat } from "@/Constants/Common";
import HasLink from "../Components/HasLink";
import { DeleteIcon, EditIcon, PlusIcon, ViewIcon } from "@/Icons";
import HasPagination from "../Components/HasPagination";
import DefaultStatus from "../Components/Status/DefaultStatus";
import { Head } from "@inertiajs/react";
import { useForm } from "react-hook-form";
import SearchFormGeneration from "../Components/SearchFormGeneration";

export default function UserList ({data, form, params}) {
    const {
        register: registerRHF,
        handleSubmit: handleSubmitRHF,
        watch: watchRHF,
        control: controlRHF,
        unregister: unregisterRHF,
        setValue: setValueRHF,
    } = useForm({ defaultValues: params });

    function onSubmit(data) {
        window.location.href = route("user.index", data);
    }

    return (
        <OfficeLayout>
            <Head title="User List" />
            <div className="mb-[20px] flex justify-end">
                <HasLink
                    color="success"
                    link={route("permissions.register")}
                >
                    <PlusIcon />
                </HasLink>
            </div>
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
            <div className="overflow-x-auto">
                <Table hoverable>
                    <Table.Head className="text-center">
                        <Table.HeadCell className="w-[30px]">ID</Table.HeadCell>
                        <Table.HeadCell>Name</Table.HeadCell>
                        <Table.HeadCell>Status</Table.HeadCell>
                        <Table.HeadCell>Created at</Table.HeadCell>

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
                                <Table.Cell>
                                    {item.name}
                                </Table.Cell>
                                <Table.Cell>
                                    <DefaultStatus value={item.status} />
                                </Table.Cell>
                                <Table.Cell>
                                    {dateTimeFormat(item.created_at)}
                                </Table.Cell>

                                <Table.Cell className="flex gap-[5px] justify-center">
                                    <HasLink
                                        link={route("user.detail", {
                                            id: item.id,
                                        })}
                                    >
                                        <ViewIcon />
                                    </HasLink>
                                    <HasLink
                                        link={route("user.edit", {
                                            id: item.id,
                                        })}
                                        color="warning"
                                    >
                                        <EditIcon />
                                    </HasLink>

                                    <Button
                                        link="#"
                                        className="bg-red-400"
                                        onClick={() =>
                                            deleteUser(item.id)
                                        }
                                    >
                                        <DeleteIcon />
                                    </Button>
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
    )
}
