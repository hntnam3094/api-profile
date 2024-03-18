import OfficeLayout from "@/Layouts/OfficeLayout";
import FormGeneration from "../Components/FormGeneration";
import { useForm } from "react-hook-form";
import { Button } from "flowbite-react";
import { router } from "@inertiajs/react";
export default function FormDetail({
    dataForm,
    structionForm,
    id,
    structionPageId,
    singleRow = 0
}) {
    const {
        register: registerRHF,
        watch: watchRHF,
        control: controlRHF,
        unregister: unregisterRHF,
        setValue: setValueRHF,
    } = useForm({ defaultValues: dataForm });

    function edit () {
        console.log(singleRow)
        if (singleRow == 1) {
            router.get(route('structionpages.single_edit', {id: structionPageId }))
        } else {
            router.get(route('structionpages.edit', {id: id, 'is_list': 0 }))
        }
    }

    return (
        <OfficeLayout>
            <FormGeneration
                    form={structionForm.form}
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
