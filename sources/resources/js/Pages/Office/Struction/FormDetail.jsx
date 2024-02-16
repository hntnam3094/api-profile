import OfficeLayout from "@/Layouts/OfficeLayout";
import FormGeneration from "../Components/FormGeneration";
import { useForm } from "react-hook-form";
import { Button } from "flowbite-react";
import HasLink from "../Components/HasLink";
import { router } from "@inertiajs/react";
export default function FormDetail({
    dataForm,
    structionForm,
    pageCode,
    code,
    id,
    structionPageId
}) {
    const {
        register: registerRHF,
        watch: watchRHF,
        control: controlRHF,
        unregister: unregisterRHF,
        setValue: setValueRHF,
    } = useForm({ defaultValues: dataForm });

    function edit () {
        router.get(route('structionpages.edit', {id: id, 'is_list': 0, 'page_code': pageCode, 'code': code }))
    }

    return (
        <OfficeLayout>
            <FormGeneration
                    form={structionForm}
                    register={registerRHF}
                    watch={watchRHF}
                    control={controlRHF}
                    unregister={unregisterRHF}
                    setValue={setValueRHF}
                    isDetail={1}
                />

                <div className="flex gap-5">
                    <Button color="warning" onClick={edit}>Edit</Button>
                    <Button onClick={() => history.back()}>Back</Button>
                </div>
        </OfficeLayout>
    );
}
